import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import { ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useTemperatureLayer = map => {
  const temperatureLayer = ref(null)
  const { showTemperature } = useGetters(['showTemperature'])

  const setupTemperatureLayer = () => {
    temperatureLayer.value = new Layer.Tile({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      visible: showTemperature.value,
      zIndex: 20,
      source: new Source.XYZ({
        projection: 'EPSG:3857',
        url: 'https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png' +
          `?appid=${process.env.OPEN_WEATHER_MAP_API_KEY}`
      })
    })

    map.value.addLayer(temperatureLayer.value)
  }

  watch(showTemperature, showTemperature => {
    temperatureLayer.value.setVisible(showTemperature)
  })

  return { setupTemperatureLayer }
}
