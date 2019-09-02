{% if access === false %}  
{{ partial("libraryer/403") }}
{% endif %}
{% if access === true %} 
<div class="main-menu-modules-wrapper row">
  <div id="app">

    <!-- Навигация -->
    <div class="navbar">
      <ul class="nav nav-list">
        <li class="nav-list-item"> <button @click="select = 0, ucd_fnrec = null, getNew()"
            class="btn btn-lg nav-btn btn-primary">Справки по
            дисциплинам</button></li>
        <li class="nav-list-item"> <button @click="select = 1, getStarted()"
            class="btn btn-lg nav-btn btn-primary medium-6 large-6">Справки по
            направлениям</button></li>
      </ul>

      <!-- справки по дисциплинам -->
      <template v-if="select == 0">
        <ul class="nav nav-list">
          <li class="nav-list-item"> <button @click="getNew()" class="btn btn-lg nav-btn btn-info">Новые</button>
          </li>
          <li class="nav-list-item"><button @click="getSuccess" class="btn btn-lg nav-btn btn-success">Принятые</button>
          </li>
          <li class="nav-list-item"><button @click="getDanger()"
              class="btn btn-lg nav-btn btn-danger">Отклоненные</button></li>
          <li class="nav-list-item"><button @click="getAll()" class="btn btn-lg nav-btn btn-primary">Все</button>
          </li>
        </ul>
      </template>
    </div>



    <!-- Контент -->
    <div class="wrapper">
      <!-- справки по дисциплинам -->
  

      <!-- справки по напрвлениям -->
      <template v-if="select == 1">
        <div class="container"
          v-if="(Object.keys(this.specialitysStarted).length > 0) || (Object.keys(this.specialitysNoStarted).length > 0)">
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