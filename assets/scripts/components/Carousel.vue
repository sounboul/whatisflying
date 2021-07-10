<template>
  <div id="carousel" class="carousel slide" data-bs-ride="carousel">

    <div v-if="pictures.length > 1" class="carousel-indicators">
      <button v-for="(picture, index) in pictures" :key="picture.id" type="button"
              :class="{ active: index === 0 }" data-bs-target="#carousel" :data-bs-slide-to="index"
              :aria-current="index === 0" :aria-label="index"></button>
    </div>
    <div class="carousel-inner">
      <div v-for="(picture, index) in pictures" :key="picture.id" class="carousel-item"
           :class="{ active: index === 0 }" :style="{ maxHeight: height }">

        <a v-if="picture.source" rel="noopener noreferrer" target="_blank" :href="picture.source">
          <img class="img-cover" :style="{ maxHeight: height }" :src="picture.url" alt="">
        </a>
        <img v-else class="img-cover" :style="{ maxHeight: height }" :src="picture.url" alt="">

        <div class="carousel-caption">

          <template v-if="picture.authorName && picture.authorProfile">
            {{ $t('copyright') }}
            <a class="text-reset" rel="author noopener noreferrer" :href="picture.authorProfile">
              <u>{{ picture.authorName }}</u>
            </a>
          </template>
          <template v-else-if="picture.authorName">
            {{ $t('copyright') }} {{ picture.authorName }}
          </template>
          <template v-else>
            {{ $t('unknown_author') }}
          </template>

          -

          <template v-if="picture.license">
            <a class="text-reset" rel="license noopener noreferrer" :href="licenseUrl(picture.license)">
              <u>{{ licenseName(picture.license) }}</u>
            </a>
          </template>
          <template v-else>
            {{ $t('unknown_license') }}
          </template>

        </div>
      </div>
    </div>

  </div>

  <template v-if="pictures.length > 1">
    <button type="button" class="carousel-control-prev" data-bs-target="#carousel" data-bs-slide="prev">
      <FontAwesomeIcon :icon="['far', 'angle-left']" size="3x" aria-hidden="true"/>
      <span class="visually-hidden">{{ $t('previous_picture') }}</span>
    </button>
    <button type="button" class="carousel-control-next" data-bs-target="#carousel" data-bs-slide="next">
      <FontAwesomeIcon :icon="['far', 'angle-right']" size="3x" aria-hidden="true"/>
      <span class="visually-hidden">{{ $t('next_picture') }}</span>
    </button>
  </template>

</template>

<script>
import FontAwesomeIcon from '@scripts/fontawesome'
import SpdxLicense from '@scripts/services/spdx-license'

export default {
  name: 'Carousel',
  components: {
    FontAwesomeIcon
  },
  props: {
    height: String,
    pictures: Array
  },
  methods: {
    licenseName (identifier) {
      return SpdxLicense.getLicenseName(identifier)
    },
    licenseUrl (identifier) {
      return SpdxLicense.getLicenseUrl(identifier)
    }
  }
}
</script>
