import Math from '@scripts/mathjs'
import { Navaid } from '@scripts/services/api'
import { CancelToken } from 'axios'
import * as OpenLayers from 'ol'
import { add } from 'ol/coordinate'
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

export const useNavaidsLayer = (map, props, selection) => {
  const cancelToken = ref(null)
  const navaidsLayer = ref(null)
  const navaidsSelect = ref(null)

  const { showNavaids } = useGetters(['showNavaids'])

  const generateNavaidIcon = (properties, zoom) => {
    const { selected, type } = properties

    return new Style.Icon({
      color: selected ? '#00000066' : undefined,
      scale: 0.125 * Math.log(zoom),
      src: require(`@images/navaid/${type}.svg`)
    })
  }

  const generateNavaidLabel = properties => {
    const { identifier, name } = properties
    const text = [identifier, name]

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

  const generateNavaidStyle = feature => {
    const zoom = map.value.getView().getZoom()
    const properties = feature.getProperties()
    const { receptionRange, slug } = properties
    const style = new Style.Style()

    if ((receptionRange >= 25 && zoom >= 10) || zoom >= 12 || props.featuredNavaids?.includes(slug)) {
      style.setImage(generateNavaidIcon(properties, zoom))
      style.setText(generateNavaidLabel(properties))
    } else if (receptionRange >= 125 || (receptionRange >= 100 && zoom >= 4) ||
      (receptionRange >= 75 && zoom >= 6) || (receptionRange >= 50 && zoom >= 8)) {
      style.setImage(generateNavaidIcon(properties, zoom))
    }

    return style
  }

  const setupNavaidsLayer = () => {
    const navaidsSource = new Source.Vector({
      strategy: LoadingStrategy.bbox,
      loader: extent => {
        cancelToken.value?.cancel('Concurrent request')
        cancelToken.value = CancelToken.source()

        const boundingBox = Projection.transformExtent(extent, 'EPSG:3857', 'EPSG:4326')
        Navaid.getNavaids({
          cancelToken: cancelToken.value.token,
          params: {
            pagination: false,
            properties: ['id', 'identifier', 'latitude', 'longitude', 'name', 'receptionRange', 'slug', 'type'],
            latitude: {
              gte: boundingBox[1],
              lte: boundingBox[3]
            },
            longitude: {
              gte: boundingBox[0],
              lte: boundingBox[2]
            }
          }
        }).then(navaids => {
          const features = []
          navaids['hydra:member'].forEach(navaid => {
            let feature = navaidsSource.getFeatureById(navaid.id)
            if (!feature) {
              const { id, latitude, longitude, ...properties } = navaid
              const coordinates = Projection.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')

              // Prevent features from overlapping if they are too close from each other.
              const radius = new Geometry.Circle(coordinates, 50)
              const featuresCount = navaidsSource.getFeaturesInExtent(radius.getExtent()).length
              if (featuresCount) {
                add(coordinates, [50 * featuresCount, -50 * featuresCount])
              }

              feature = new OpenLayers.Feature({
                geometry: new Geometry.Point(coordinates)
              })

              feature.setId(id)
              feature.setProperties(properties)
              features.push(feature)
            }

            navaidsSource.addFeatures(features)
          })
        })
      }
    })

    navaidsLayer.value = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      source: navaidsSource,
      style: feature => generateNavaidStyle(feature),
      visible: props.forceShowNavaids || showNavaids.value,
      zIndex: 100
    })

    navaidsSelect.value = new Interaction.Select({
      condition: Condition.singleClick,
      features: new OpenLayers.Collection(),
      layers: layer => layer.ol_uid === navaidsLayer.value.ol_uid,
      filter: feature => {
        const { slug } = feature.getProperties()
        return !props.featuredNavaids?.includes(slug)
      },
      style: feature => {
        const zoom = map.value.getView().getZoom()
        const properties = feature.getProperties()

        return new Style.Style({
          zIndex: 10000,
          image: generateNavaidIcon(properties, zoom),
          text: generateNavaidLabel(properties)
        })
      }
    })

    navaidsSelect.value.on('select', event => {
      if (event.deselected.length) {
        const feature = event.deselected[0]
        feature.setProperties({ selected: false })
        delete selection.value.navaid
      }

      if (event.selected.length) {
        const feature = event.selected[0]
        feature.setProperties({ selected: true })
        const { slug } = feature.getProperties()
        selection.value.navaid = slug
      }
    })

    map.value.addLayer(navaidsLayer.value)
    map.value.addInteraction(navaidsSelect.value)
  }

  watch(showNavaids, showNavaids => {
    navaidsLayer.value.setVisible(showNavaids)
  })

  watch(() => selection.value.navaid, navaid => {
    if (!navaid) {
      navaidsSelect.value.getFeatures().forEach(feature => {
        navaidsSelect.value.getFeatures().remove(feature)
        feature.setProperties({ selected: false })
      })
    }
  })

  onUnmounted(() => cancelToken.value?.cancel('Component unmounted'))

  return { setupNavaidsLayer }
}
