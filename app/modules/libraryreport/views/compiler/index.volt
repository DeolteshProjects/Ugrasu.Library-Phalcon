{% if access === false %}
{{ partial("compiler/403") }}
{% endif %}
{% if access === true %}
<div class="main-menu-modules-wrapper row">
  <div id="app">
    <!-- Навигация -->
    <div class="navbar">
      <ul class="nav nav-list">
        <li class="nav-list-item" id="listButton" ><button @click="page = 0, getStarted()" class="btn btn-medium nav-btn">Составленные
            библиографические справки</button></li>
        <li class="nav-list-item"><button  @click="page = 1, edit = 0, status = null" class="btn btn-medium nav-btn">Составить
            новую</button></li>
        <li class="nav-list-item" v-if="fnrec != null"><button class="btn btn-medium nav-btn">Библиографическая справка
            №{{'{{ fnrec }}'}}</button></li>
      </ul>
    </div>

    <!-- справки по дисциплинам -->
    <template v-if="page == 0">
      <!-- 
        <ul class="nav nav-list">
        <li class="nav-list-item"><button @click="getStarted()" class="btn btn-medium nav-btn">По направлениям</button>
        </li>
      </ul>
      -->
      <!-- Контент -->
      <div class="wrapper">
        <div class="container" v-if="(fnrec != null)">
          {{ partial("compiler/report/report") }}
        </div>
        <div class="container" v-if="(Object.keys(specialitysStarted).length > 0)">
          {{ partial("compiler/speciality/startedList") }}
        </div>
        <div class="container" v-if="(Object.keys(disciplinesStarted).length > 0) && (fnrec == null)">
            {{ partial("compiler/discipline/startedList") }}
        </div>
        <div class="container" v-if="(edit == 1)">
            {{ partial("compiler/report/showEditReport") }}
        </div>
      </div>
    </template>



    <template v-if="page == 1">
      <div class="navbar">
        <ul class="nav nav-list">
          <!--
          <li class="nav-list-item" v-if="status == null"> <button v-on:click="" class="btn btn-medium nav-btn">Выбор
              года набора и направления</button></li>
            -->
          <li class="nav-list-item" v-if="status != null"><button v-on:click="status = 1"
              class="btn btn-medium nav-btn">Поиск литературы</button></li>
          <li class="nav-list-item" v-if="full == 1"><button v-on:click="status = 2"
              class="btn btn-medium nav-btn">Составляемая библиографическая справка</button></li>
        </ul>
      </div>
      <!-- Контент -->
      <div class="wrapper">
        <div class="container" v-if="(status == null) && (edit == 0)">
          {{ partial("compiler/createnew/createForm") }}
          <div class="container">
          {{ partial("compiler/createnew/listEmpty") }}
          </div>
        </div>
        <div class="container" v-if="status == 1">
          {{ partial("compiler/createnew/searchForm") }}
        </div>
        <div class="container" v-if="(status == 2) && (edit == 0)">
          {{ partial("compiler/createnew/showForm") }}
        </div>
        <div class="container" v-if="(status == 2) && (edit == 1)">
          {{ partial("compiler/report/showEditReport") }}
        </div>
      </div>
    </template>


  </div>
</div>
{% endif %}