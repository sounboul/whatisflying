<template>
  <div v-if="selection?.fix" class="card card-body">
    <div class="d-flex justify-content-between align-items-start">

      <template v-if="fixLoaded">
        <h2>{{ fix.identifier }}</h2>
      </template>
      <template v-else>
        <ContentLoader class="mb-3" width="100" height="30.63">
          <rect x="0" y="0" width="100" height="24.5" rx="2" ry="2"/>
        </ContentLoader>
      </template>

      <a class="ms-2 text-reset" href="#" @click.prevent="delete selection.fix">
        <span class="visually-hidden">{{ $t('close_the_fix_details') }}</span>
        <FontAwesomeIcon :icon="['fal', 'xmark']" size="2x" aria-hidden="true"/>
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <tbody>
          <tr>
            <th scope="row" class="col-6">{{ $t('usage') }}</th>
            <td class="col-6">

              <template v-if="fixLoaded">

                <template v-if="fix.usage === 'ENROUTE'">
                  {{ $t('en_route_navigation') }}
                </template>
                <template v-else-if="fix.usage === 'TERMINAL'">
                  {{ $t('terminal_area_navigation') }}
                </template>
                <template v-else>
                  {{ $t('unknown_usage') }}
                </template>

              </template>
              <template v-else>
                <ContentLoader width="200" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('latitude') }}</th>
            <td class="col-6">

              <template v-if="fixLoaded">
                {{ $n($m.round(fix.latitude, 5)) }}° /
                {{ $dms(fix.latitude) }}
                {{ fix.latitude >= 0 ? 'N' : 'S' }}
              </template>
              <template v-else>
                <ContentLoader width="200" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('longitude') }}</th>
            <td class="col-6">

              <template v-if="fixLoaded">
                {{ $n($m.round(fix.longitude, 5)) }}° /
                {{ $dms(fix.longitude) }}
                {{ fix.longitude >= 0 ? 'E' : 'W' }}
              </template>
              <template v-else>
                <ContentLoader width="200" height="14"/>
              </template>

            </td>
          </tr>
          <tr>
            <th scope="row" class="col-6">{{ $t('icao_region') }}</th>
            <td class="col-6">

              <template v-if="fixLoaded">
                {{ fix.region }}
              </template>
              <template v-else>
                <ContentLoader width="50" height="14"/>
              </template>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import ContentLoader from '@scripts/components/ContentLoader'
import FontAwesomeIcon from '@scripts/fontawesome'
import { Fix } from '@scripts/services/api'
import { CancelToken } from 'axios'

export default {
  name: 'FixDetails',
  components: {
    ContentLoader,
    FontAwesomeIcon
  },
  inject: ['selection'],
  methods: {
    loadFix () {
      this.cancelToken?.cancel('Concurrent request')
      this.cancelToken = CancelToken.source()
      this.fixLoaded = false

      Fix.getFix(this.selection?.fix, {
        cancelToken: this.cancelToken.token
      }).then(fix => {
        this.fix = fix
        this.fixLoaded = true
      })
    }
  },
  watch: {
    selection: {
      deep: true,
      handler (selection) {
        if (selection?.fix) {
          this.loadFix()
        }
      }
    }
  },
  data () {
    return {
      cancelToken: null,
      fix: null,
      fixLoaded: false
    }
  },
  unmounted () {
    this.cancelToken?.cancel('Component unmounted')
  }
}
</script>
