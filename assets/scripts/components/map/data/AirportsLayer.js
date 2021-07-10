import Math from '@scripts/mathjs'
import { Airport } from '@scripts/services/api'
import { CancelToken } from 'axios'
import * as OpenLayers from 'ol'
import * as Condition from 'ol/events/condition'
import * as Geometry from 'ol/geom'
import * as Interaction from 'ol/interaction'
import * as Layer from 'ol/layer'
import * as LoadingStrategy from 'ol/loadingstrategy'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import * as Style from 'ol/style'
import { onUnmounted, ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useAirportsLayer = (map, props, selection) => {
  const cancelToken = ref(null)
  const airportsLayer = ref(null)
  const airportsSelect = ref(null)

  const { showAirports } = useGetters(['showAirports'])

  const generateAirportIcon = (properties, zoom) => {
    const { selected, type } = properties

    return new Style.Icon({
      color: selected ? '#00000066' : undefined,
      scale: 0.125 * Math.log(zoom),
      src: require(`@images/airport/${type}.svg`)
    })
  }

  const generateAirportLabel = properties => {
    const { icaoCode, name } = properties
    const text = [icaoCode, name]

    return new Style.Text({
      font: 'normal 500 11.5px "Fira Sans", sans-serif',
      offsetX: 0,
      offsetY: 25,
      padding: [4, 2, 2, 4],
      text: text.join('\n'),
      textAlign: 'center',
      textBaseline: 'top',
      backgroundFill: new Style.Fill({
        color: 'rgba(46, 50, 55, 0.65)'
      }),
      fill: new Style.Fill({
        color: '#f6f8fa'
      })
    })
  }

  const generateAirportStyle = feature => {
    const zoom = map.value.getView().getZoom()
    const properties = feature.getProperties()
    const { icaoCode, type } = properties
    const style = new Style.Style()

    if (zoom >= 10 || props.featuredAirports?.includes(icaoCode)) {
      style.setImage(generateAirportIcon(properties, zoom))
      style.setText(generateAirportLabel(properties))
    } else if ((type === 'medium' && zoom >= 8) || type === 'large') {
      style.setImage(generateAirportIcon(properties, zoom))
    }

    return style
  }

  const setupAirportsLayer = () => {
    const airportsSource = new Source.Vector({
      strategy: LoadingStrategy.bbox,
      loader: extent => {
        cancelToken.value?.cancel('Concurrent request')
        cancelToken.value = CancelToken.source()

        const boundingBox = Projection.transformExtent(extent, 'EPSG:3857', 'EPSG:4326')
        Airport.getAirports({
          cancelToken: cancelToken.value.token,
          params: {
            pagination: false,
            properties: ['id', 'icaoCode', 'latitude', 'longitude', 'name', 'type'],
            latitude: {
              gte: boundingBox[1],
              lte: boundingBox[3]
            },
            longitude: {
              gte: boundingBox[0],
              lte: boundingBox[2]
            }
          }
        }).then(airports => {
          const features = []
          airports['hydra:member'].forEach(airport => {
            let feature = airportsSource.getFeatureById(airport.id)
            if (!feature) {
              const { id, latitude, longitude, ...properties } = airport
              const coordinates = Projection.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')

              feature = new OpenLayers.Feature({
                geometry: new Geometry.Point(coordinates)
              })

              feature.setId(id)
              feature.setProperties(properties)
              features.push(feature)
            }
          })

          airportsSource.addFeatures(features)
        })
      }
    })

    airportsLayer.value = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      source: airportsSource,
      style: feature => generateAirportStyle(feature),
      visible: props.forceShowAirports || showAirports.value,
      zIndex: 150
    })

    airportsSelect.value = new Interaction.Select({
      condition: Condition.singleClick,
      features: new OpenLayers.Collection(),
      filter: feature => {
        const { icaoCode } = feature.getProperties()
        return !props.featuredAirports?.includes(icaoCode) || props.forceAllowAirportSelection
      },
      layers: layer => layer.ol_uid === airportsLayer.value.ol_uid,
      style: feature => {
        const zoom = map.value.getView().getZoom()
        const properties = feature.getProperties()

        return new Style.Style({
          zIndex: 10000,
          image: generateAirportIcon(properties, zoom),
          text: generateAirportLabel(properties)
        })
      }
    })

    airportsSelect.value.on('select', event => {
      if (event.deselected.length) {
        const feature = event.deselected[0]
        feature.setProperties({ selected: false })
        delete selection.value.airport
      }

      if (event.selected.length) {
        const feature = event.selected[0]
        feature.setProperties({ selected: true })
        const { icaoCode } = feature.getProperties()
        selection.value.airport = icaoCode
      }
    })

    map.value.addLayer(airportsLayer.value)
    map.value.addInteraction(airportsSelect.value)
  }

  watch(showAirports, showAirports => {
    airportsLayer.value.setVisible(showAirports)
  })

  watch(() => selection.value.airport, airport => {
    if (!airport) {
      airportsSelect.value.getFeatures().forEach(feature => {
        airportsSelect.value.getFeatures().remove(feature)
        feature.setProperties({ selected: false })
      })
    }
  })

  onUnmounted(() => cancelToken.value?.cancel('Component unmounted'))

  return { setupAirportsLayer }
}
