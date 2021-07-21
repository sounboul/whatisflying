import Math from '@scripts/mathjs'
import { DateTime } from 'luxon'
import { DEVICE_PIXEL_RATIO } from 'ol/has'
import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import { watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useSatelliteLayer = map => {
  const { baseLayer } = useGetters(['baseLayer', 'locale'])

  const setupSatelliteLayer = () => {
    const pixelRatio = Math.ceil(DEVICE_PIXEL_RATIO)
    const tileSize = pixelRatio > 1 ? 512 : 256
    const satelliteLayer = new Layer.Tile({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      visible: baseLayer.value === 'satellite',
      zIndex: 10,
      source: new Source.XYZ({
        attributions: `Copyright &copy; ${DateTime.utc().year} <a href="https://developer.here.com">HERE</a>`,
        tilePixelRatio: pixelRatio > 1 ? 2 : 1,
        url: 'https://{1-4}.aerial.maps.ls.hereapi.com/maptile/2.1/maptile/newest/satellite.day/{z}/{x}/{y}/' +
          `${tileSize}/png8?apiKey=${process.env.HERE_API_KEY}`
      })
    })

    map.value.addLayer(satelliteLayer)

    watch(baseLayer, baseLayer => {
      satelliteLayer.setVisible(baseLayer === 'satellite')
    })
  }

  return { setupSatelliteLayer }
}
