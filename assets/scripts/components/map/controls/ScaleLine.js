import * as Control from 'ol/control'
import { Units } from 'ol/control/ScaleLine'

export const useScaleLine = map => {
  const setupScaleLine = () => {
    const scaleLine = new Control.ScaleLine({
      className: 'map-scale',
      minWidth: 100,
      units: Units.NAUTICAL
    })

    map.value.addControl(scaleLine)
  }

  return { setupScaleLine }
}
