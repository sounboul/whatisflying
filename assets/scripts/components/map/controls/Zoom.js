import i18n from '@scripts/i18n'
import * as Control from 'ol/control'

export const useZoom = map => {
  const setupZoom = () => {
    const zoom = new Control.Zoom({
      className: 'map-zoom',
      zoomInTipLabel: i18n.global.t('zoom_in'),
      zoomOutTipLabel: i18n.global.t('zoom_out')
    })

    map.value.addControl(zoom)
  }

  return { setupZoom }
}
