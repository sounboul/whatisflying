import Math from '@scripts/mathjs'
import * as OpenLayers from 'ol'
import * as Geometry from 'ol/geom'
import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import * as Style from 'ol/style'

export const useGeolocation = (map, geolocationPosition) => {
  const setupGeolocation = () => {
    const geolocationSource = new Source.Vector()
    const geolocationLayer = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      source: geolocationSource,
      zIndex: 300
    })

    map.value.addLayer(geolocationLayer)

    const geolocation = new OpenLayers.Geolocation({
      projection: map.value.getView().getProjection(),
      tracking: true,
      trackingOptions: {
        enableHighAccuracy: true
      }
    })

    geolocation.on('change:position', () => {
      const position = geolocation.getPosition()
      if (position) {
        let feature = geolocationSource.getFeatureById('position')
        if (!feature) {
          feature = new OpenLayers.Feature()
          feature.setId('position')
          feature.setStyle(() => {
            const icon = require('@images/marker.svg')
            const zoom = map.value.getView().getZoom()

            return new Style.Style({
              image: new Style.Icon({
                anchor: [0.5, 0.5],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                scale: 0.0625 * Math.log(zoom),
                src: icon
              })
            })
          })

          geolocationSource.addFeature(feature)
        }

        feature.setGeometry(new Geometry.Point(position))
        geolocationPosition.value = position
      }
    })
  }

  return { setupGeolocation }
}
