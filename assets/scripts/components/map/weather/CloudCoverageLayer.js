import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import { ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useCloudCoverageLayer = map => {
  const cloudCoverageLayer = ref(null)
  const { showCloudCoverage } = useGetters(['showCloudCoverage'])

  const setupCloudCoverageLayer = () => {
    cloudCoverageLayer.value = new Layer.Tile({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      visible: showCloudCoverage.value,
      zIndex: 20,
      source: new Source.XYZ({
        projection: 'EPSG:3857',
        url: 'https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png' +
          `?appid=${process.env.OPEN_WEATHER_MAP_API_KEY}`
      })
    })

    map.value.addLayer(cloudCoverageLayer.value)
  }

  watch(showCloudCoverage, showCloudCoverage => {
    cloudCoverageLayer.value.setVisible(showCloudCoverage)
  })

  return { setupCloudCoverageLayer }
}
