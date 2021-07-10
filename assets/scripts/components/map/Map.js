import * as OpenLayers from 'ol'
import * as Projection from 'ol/proj'
import { watch } from 'vue'

export const useMap = (map, props, context, target) => {
  const { emit } = context

  const setupMap = () => {
    map.value = new OpenLayers.Map({
      controls: [],
      target: document.querySelector(target),
      view: new OpenLayers.View({
        center: Projection.transform([props.longitude, props.latitude], 'EPSG:4326', 'EPSG:3857'),
        constrainResolution: true,
        extent: Projection.transformExtent([-180, -90, 180, 90], 'EPSG:4326', 'EPSG:3857'),
        maxZoom: 18,
        minZoom: 3,
        projection: 'EPSG:3857',
        rotation: props.rotation,
        zoom: props.zoom
      })
    })

    map.value.on('moveend', event => {
      const view = event.map.getView()
      const center = Projection.transform(view.getCenter(), 'EPSG:3857', 'EPSG:4326')
      const state = {
        center: [center[0].toFixed(7), center[1].toFixed(7)],
        rotation: view.getRotation(),
        zoom: view.getZoom()
      }

      emit('stateChanged', state)
    })
  }

  watch(() => props.latitude, latitude => {
    const view = map.value.getView()
    const center = Projection.transform(view.getCenter(), 'EPSG:3857', 'EPSG:4326')
    center[1] = latitude
    view.setCenter(Projection.transform(center, 'EPSG:4326', 'EPSG:3857'))
  })

  watch(() => props.longitude, longitude => {
    const view = map.value.getView()
    const center = Projection.transform(view.getCenter(), 'EPSG:3857', 'EPSG:4326')
    center[0] = longitude
    view.setCenter(Projection.transform(center, 'EPSG:4326', 'EPSG:3857'))
  })

  watch(() => props.rotation, rotation => {
    const view = map.value.getView()
    view.setRotation(rotation)
  })

  watch(() => props.zoom, zoom => {
    const view = map.value.getView()
    view.setZoom(zoom)
  })

  return { setupMap }
}
