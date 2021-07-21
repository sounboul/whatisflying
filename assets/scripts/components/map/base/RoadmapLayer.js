import Math from '@scripts/mathjs'
import { DateTime } from 'luxon'
import { DEVICE_PIXEL_RATIO } from 'ol/has'
import * as Layer from 'ol/layer'
import * as Projection from 'ol/proj'
import * as Source from 'ol/source'
import { watch } from 'vue'
import { useGetters } from 'vuex-composition-helpers'

const ROADMAP_LANGUAGES = {
  en: 'eng',
  fr: 'fre'
}

const ROADMAP_RESOLUTIONS = {
  1: 72,
  2: 250,
  3: 320,
  4: 500
}

export const useRoadmapLayer = map => {
  const { baseLayer, darkMode, locale } = useGetters(['baseLayer', 'darkMode', 'locale'])
  const pixelRatio = Math.ceil(DEVICE_PIXEL_RATIO)

  const getSourceUrl = () => {
    const tileSize = pixelRatio > 1 ? 512 : 256
    const resolution = ROADMAP_RESOLUTIONS[pixelRatio]
    const language = ROADMAP_LANGUAGES[locale]
    const style = darkMode.value ? 'night' : 'day'

    return `https://{1-4}.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/normal.${style}/{z}/{x}/{y}/` +
      `${tileSize}/png8?apiKey=${process.env.HERE_API_KEY}&lg=${language}&ppi=${resolution}`
  }

  const setupRoadmapLayer = () => {
    const roadmapLayer = new Layer.Tile({
      extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
      visible: baseLayer.value === 'roadmap',
      zIndex: 10,
      source: new Source.XYZ({
        attributions: `Copyright &copy; ${DateTime.utc().year} <a href="https://developer.here.com">HERE</a>`,
        tilePixelRatio: pixelRatio > 1 ? 2 : 1,
        url: getSourceUrl()
      })
    })

    map.value.addLayer(roadmapLayer)

    watch(baseLayer, baseLayer => {
      roadmapLayer.setVisible(baseLayer === 'roadmap')
    })

    watch(darkMode, () => {
      const source = roadmapLayer.getSource()
      source.setUrl(getSourceUrl())
      source.refresh()
    })
  }

  return { setupRoadmapLayer }
}
