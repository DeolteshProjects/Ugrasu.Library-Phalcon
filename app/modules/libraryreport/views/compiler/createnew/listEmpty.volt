<template v-if="Object.keys(listEmpty).length > 0">

  <!-- Заголовок модуля -->
  <div class="modules-header">
    <div class="header">
      <div class="header-title">
        <p>
          <h4 class="title">Библиографическая справка содержит в себе:</h4>
        </p>
      </div>
      <div class="header-content">
        <table>
          <tbody>
            <tr>
              <td><button v-on:click="listEmptyPage = 'success'"
                  class="btn btn-lg btn-success col-md-12">Составленные {{'{{ Object.keys(listEmpty[0]).length }}'}} шт.</button>
              </td>
              <td><button v-on:click="listEmptyPage = 'empty'"
                  class="btn btn-lg btn-warning col-md-12">Несоставленные {{'{{ Object.keys(listEmpty[1]).length }}'}} шт.</button>
              </td>
              <td><button v-on:click="listEmptyPage = 'danger'"
                class="btn btn-lg btn-danger col-md-12">Отклоненные {{'{{ Object.keys(listEmpty[2]).length }}'}} шт.</button>
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
      {{ partial('compiler/createnew/listSuccess') }}
    </template>

    <template v-if="listEmptyPage == 'empty'">
        {{ partial('compiler/createnew/listEmptyes') }}
    </template>

    <template v-if="listEmptyPage == 'danger'">
      {{ partial('compiler/createnew/listDanger') }}
    </template>

  </div>
</template>