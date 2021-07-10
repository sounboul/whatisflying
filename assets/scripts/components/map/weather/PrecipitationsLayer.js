import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import { ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const usePrecipitationsLayer = map => {
  const precipitationsLayer = ref(null)
  const { showPrecipitations } = useGetters(['showPrecipitations'])

  const setupPrecipitationsLayer = () => {
    precipitationsLayer.value = new Layer.Tile({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      visible: showPrecipitations.value,
      zIndex: 20,
      source: new Source.XYZ({
        projection: 'EPSG:3857',
        url: 'https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png' +
          `?appid=${process.env.OPEN_WEATHER_MAP_API_KEY}`
      })
    })

    map.value.addLayer(precipitationsLayer.value)
  }

  watch(showPrecipitations, showPrecipitations => {
    precipitationsLayer.value.setVisible(showPrecipitations)
  })

  return { setupPrecipitationsLayer }
}
