<template>
  <CenteredLayout max-width="900px">

    <template #title>
      <slot name="title"/>
    </template>

    <template #content>
      <div class="row g-3">
        <div class="col-12 col-lg-4">
          <div class="card card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'user_preferences' }" active-class="active">
                  {{ $t('preferences') }}
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'user_security' }" active-class="active">
                  {{ $t('security') }}
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'user_privacy' }" active-class="active">
                  {{ $t('privacy') }}
                </RouterLink>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-lg-8">
          <slot name="content"/>
        </div>
      </div>
    </template>

  </CenteredLayout>
</template>

<script>
import CenteredLayout from '@scripts/layouts/CenteredLayout'

export default {
  name: 'UserLayout',
  components: {
    CenteredLayout
  }
}
</script>
