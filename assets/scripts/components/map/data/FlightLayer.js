import { Flight } from '@scripts/services/api'
import Arc from 'arc'
import { CancelToken } from 'axios'
import * as OpenLayers from 'ol'
import * as Geometry from 'ol/geom'
import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import * as Style from 'ol/style'
import { onUnmounted, ref } from 'vue'

export const useFlightLayer = (map, props) => {
  const cancelToken = ref(null)
  const flightLayer = ref(null)

  const setupFlightLayer = () => {
    const flightSource = new Source.Vector({
      loader: () => {
        cancelToken.value?.cancel('Concurrent request')
        cancelToken.value = CancelToken.source()

        Flight.getFlight(props.flightNumber, {
          cancelToken: cancelToken.value.token
        }).then(flight => {
          const waypoints = []
          const { arrivalAirport, departureAirport, layoverAirports } = flight

          const { latitude: departureLatitude, longitude: departureLongitude } = departureAirport
          waypoints.push([departureLongitude, departureLatitude])

          layoverAirports.forEach(layoverAirport => {
            const { latitude, longitude } = layoverAirport
            waypoints.push([longitude, latitude])
          })

          const { latitude: arrivalLatitude, longitude: arrivalLongitude } = arrivalAirport
          waypoints.push([arrivalLongitude, arrivalLatitude])

          for (let i = 0; i < waypoints.length; i += 1) {
            const segment = waypoints.slice(i, i + 2)
            if (segment.length === 2) {
              const generator = new Arc.GreatCircle({
                x: segment[0][0],
                y: segment[0][1]
              }, {
                x: segment[1][0],
                y: segment[1][1]
              })
              const arc = generator.Arc(100, {
                offset: 10
              })
              const coordinates = arc.geometries[0].coords
              const geometry = new Geometry.LineString(coordinates)
              geometry.transform('EPSG:4326', 'EPSG:3857')
              const feature = new OpenLayers.Feature({
                geometry
              })

              flightSource.addFeature(feature)

              map.value.getView().fit(geometry, {
                size: map.value.getSize()
              })
            }
          }
        })
      }
    })

    flightLayer.value = new Layer.Vector({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      source: flightSource,
      style: new Style.Style({
        stroke: new Style.Stroke({
          color: '#0085ad',
          width: 4
        })
      }),
      visible: typeof props.flightNumber !== 'undefined',
      zIndex: 120
    })

    map.value.addLayer(flightLayer.value)
  }

  onUnmounted(() => cancelToken.value?.cancel('Component unmounted'))

  return { setupFlightLayer }
}
