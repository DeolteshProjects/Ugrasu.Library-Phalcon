{% if access === false %}
{{ partial("libraryer/403") }}
{% endif %}
{% if access === true %}
<div class="main-menu-modules-wrapper row">
  <div id="app">

    <!-- Навигация -->
    <div class="navbar">
      <ul class="nav nav-list">
        <li class="nav-list-item"> <button @click="select = 0, ucd_fnrec = null, getStartedNew()"
            class="btn btn-lg nav-btn btn-warning">Новые</button></li>
        <li class="nav-list-item"> <button @click="select = 1, getStarted()"
            class="btn btn-lg nav-btn btn-primary medium-6 large-6">Все справки</button></li>
      </ul>
    </div>



    <!-- Контент -->
    <div class="wrapper">
      <!-- справки по дисциплинам -->
      <template v-if="select == 0">
        <div class="container"
          v-if="(Object.keys(this.specialitysStarted).length > 0) || (Object.keys(this.specialitysNoStarted).length > 0)">
          {{ partial("libraryer/speciality/startedList") }}
        </div>
      </template>

      <!-- справки по напрвлениям -->
      <template v-if="select == 1">
        <div class="container"
          v-if="(Object.keys(this.specialitysStarted).length > 0)">
          {{ partial("libraryer/speciality/startedList") }}
        </div>
        <div class="container" v-if="(Object.keys(this.disciplinesStarted).length > 0) && (ucd_fnrec == null)">
          {{ partial("libraryer/discipline/startedList") }}
        </div>
        <div class="container" v-if="ucd_fnrec != null">
          {{ partial("libraryer/discipline/report") }}
        </div>
      </template>
    </div>
  </div>
</div>
{% endif %}