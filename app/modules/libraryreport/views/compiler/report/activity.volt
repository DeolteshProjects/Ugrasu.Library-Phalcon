<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <h4 class="title">История активности библиографической справки №{{'{{ report[0]["UCD_FNREC"] }}'}}</h4>
    </div>
    <div class="header-content">
      <!-- -->
    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">
  {{'{{ report[0]["ACTIVITY"]["Time"] }}'}}
  <!-- Форма вывода результатов поиска -->
  <div class="block-search-result small-12 medium-12 large-12 columns">
    <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
    <table cellspacing="0">
      <thead>
        <tr>
          <td>#</td>
          <td>Дата</td>
          <td>Актив</td>
          <td>Состояние</td>
          <td>Комментарий</td>
        </tr>
      </thead>
      <tbody>
        <template v-for='(act, index) in report[0]["ACTIVITY"].slice().reverse()'>
          <tr class="">
            <td>{{'{{ index+1 }}'}}</td>
            <td>{{'{{ act["Time"] }}'}}</td>
            <td>{{'{{ act["Activ"] }}'}}</td>
            <td class="btn-warning" v-if="act['Activiry'] == 0">Создание</td>
            <td class="btn-danger" v-if="act['Activiry'] == 2">Отклонение</td>
            <td class="btn-secondary" v-if="act['Activiry'] == 8">Исправление</td>
            <td class="btn-success" v-if="act['Activiry'] == 10">Принятие</td>
            <td class="btn-info" v-if="act['Activiry'] == 11">Печать</td>
            <td>{{'{{ act["Comment"] }}'}}</td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</div>