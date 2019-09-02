<!-- Заголовок модуля -->
<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <p>
        <h5 v-if="Object.keys(disciplinesStarted[0]).length > 0" class="title">Библиографическая справка
          "{{'{{ speccode }}'}} - {{'{{ disciplinesStarted[0][0]["SPECIALITY"] }}'}}"
          [{{'{{ disciplinesStarted[0][0]["YEARED"] }}'}}] содержит в себе:</h5>
        <h5 v-else class="title">Библиографическая справка
          "{{'{{ speccode }}'}} - {{'{{ disciplinesStarted[1][0]["SPECIALITY"] }}'}}"
          [{{'{{ disciplinesStarted[1][0]["FYEARED"] }}'}}] содержит в себе:</h5>
      </p>
    </div>
    <div class="header-content">
      <table>
        <tbody>
          <tr>
            <td><button v-on:click="listEmptyPage = 'success'" class="btn btn-lg btn-success col-md-12">Составленные
                {{'{{ Object.keys(disciplinesStarted[0]).length }}'}} шт.</button>
            </td>

            <td><button v-on:click="listEmptyPage = 'empty'" class="btn btn-lg btn-warning col-md-12">Несоставленные
                {{'{{ Object.keys(disciplinesStarted[1]).length }}'}} шт.</button>
            </td>
            <td><button v-on:click="listEmptyPage = 'danger'" class="btn btn-lg btn-danger col-md-12">Отклоненные
                {{'{{ Object.keys(disciplinesStarted[2]).length }}'}} шт.</button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">
  <template v-if="listEmptyPage == 'success'">
    {{ partial('compiler/discipline/listSuccess') }}
  </template>

  <template v-if="listEmptyPage == 'empty'">
    {{ partial('compiler/discipline/listEmpty') }}
  </template>

  <template v-if="listEmptyPage == 'danger'">
    {{ partial('compiler/discipline/listDanger') }}
  </template>
</div>