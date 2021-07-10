import * as Control from 'ol/control'

export const useAttribution = map => {
  const setupAttribution = () => {
    const attribution = new Control.Attribution({
      className: 'map-attribution',
      collapsible: false
    })

    map.value.addControl(attribution)
  }

  return { setupAttribution }
}
