import * as OpenLayers from 'ol'
import * as Style from 'ol/style'
import { ref, watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

export const useGraticule = map => {
  const graticule = ref(null)

  const { showGraticule } = useGetters(['showGraticule'])

  const setupGraticule = () => {
    graticule.value = new OpenLayers.Graticule({
      font: 'normal 500 11.5px "Fira Sans", sans-serif',
      map: map.value,
      showLabels: true,
      visible: showGraticule.value,
      strokeStyle: new Style.Stroke({
        color: '#252525',
        lineDash: [0.5, 4],
        width: 1
      })
    })
  }

  watch(showGraticule, showGraticule => {
    graticule.value.setVisible(showGraticule)
    map.value.renderSync()
  })

  return { setupGraticule }
}
