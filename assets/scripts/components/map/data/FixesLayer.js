import Math from '@scripts/mathjs'
import { Fix } from '@scripts/services/api'
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

export const useFixesLayer = (map, props, selection) => {
  const cancelToken = ref(null)
  const fixesLayer = ref(null)
  const fixesSelect = ref(null)

  const { showFixes } = useGetters(['showFixes'])

  const generateFixIcon = zoom => {
    return new Style.Icon({
      scale: 0.0625 * Math.log(zoom),
      src: require('@images/fix.svg')
    })
  }

  const generateFixLabel = properties => {
    const { identifier } = properties

    return new Style.Text({
      font: 'normal 500 11.5px "Fira Sans", sans-serif',
      offsetX: 0,
      offsetY: 15,
      padding: [2, 0, 0, 2],
      text: identifier,
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

  const generateFixStyle = feature => {
    const zoom = map.value.getView().getZoom()
    const properties = feature.getProperties()
    const { usage } = properties
    const style = new Style.Style()

    if (usage === 'ENROUTE' || zoom >= 8) {
      style.setImage(generateFixIcon(zoom))
    }

    if (zoom >= 12) {
      style.setText(generateFixLabel(properties))
    }

    return style
  }

  const setupFixesLayer = () => {
    const fixesSource = new Source.Vector({
      strategy: LoadingStrategy.bbox,
      loader: extent => {
        cancelToken.value?.cancel('Concurrent request')
        cancelToken.value = CancelToken.source()

        const boundingBox = Projection.transformExtent(extent, 'EPSG:3857', 'EPSG:4326')
        Fix.getFixes({
          cancelToken: cancelToken.value.token,
          params: {
            pagination: false,
            properties: ['id', 'identifier', 'latitude', 'longitude', 'slug', 'usage'],
            latitude: {
              gte: boundingBox[1],
              lte: boundingBox[3]
            },
            longitude: {
              gte: boundingBox[0],
              lte: boundingBox[2]
            }
          }
        }).then(fixes => {
          const features = []
          fixes['hydra:member'].forEach(fix => {
            let feature = fixesSource.getFeatureById(fix.id)
            if (!feature) {
              const { id, latitude, longitude, ...properties } = fix
              const coordinates = Projection.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')

              feature = new OpenLayers.Feature({
                geometry: new Geometry.Point(coordinates)
              })

              feature.setId(id)
              feature.setProperties(properties)
              features.push(feature)
            }
          })

          fixesSource.addFeatures(features)
        })
      }
    })

    fixesLayer.value = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      minZoom: 8,
      source: fixesSource,
      style: feature => generateFixStyle(feature),
      visible: props.forceShowFixes || showFixes.value,
      zIndex: 100
    })

    fixesSelect.value = new Interaction.Select({
      condition: Condition.singleClick,
      features: new OpenLayers.Collection(),
      layers: layer => layer.ol_uid === fixesLayer.value.ol_uid,
      style: feature => {
        const zoom = map.value.getView().getZoom()
        const properties = feature.getProperties()

        return new Style.Style({
          zIndex: 10000,
          image: generateFixIcon(zoom),
          text: generateFixLabel(properties)
        })
      }
    })

    fixesSelect.value.on('select', event => {
      if (event.deselected.length) {
        const feature = event.deselected[0]
        feature.setProperties({ selected: false })
        delete selection.value.fix
      }

      if (event.selected.length) {
        const feature = event.selected[0]
        feature.setProperties({ selected: true })
        const { slug } = feature.getProperties()
        selection.value.fix = slug
      }
    })

    map.value.addLayer(fixesLayer.value)
    map.value.addInteraction(fixesSelect.value)
  }

  watch(showFixes, showFixes => {
    fixesLayer.value.setVisible(showFixes)
  })

  watch(() => selection.value.fix, fix => {
    if (!fix) {
      fixesSelect.value.getFeatures().forEach(feature => {
        fixesSelect.value.getFeatures().remove(feature)
        feature.setProperties({ selected: false })
      })
    }
  })

  onUnmounted(() => cancelToken.value?.cancel('Component unmounted'))

  return { setupFixesLayer }
}
