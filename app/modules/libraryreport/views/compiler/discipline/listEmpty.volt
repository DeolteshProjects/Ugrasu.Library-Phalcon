<!-- Форма вывода результатов поиска -->
<div class="small-12 medium-12 large-12 columns">
  <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
  <table cellspacing="0">
    <thead class="btn-warning">
      <!--
      <tr>
        <td colspan="3">Несоставленные</td>
      </tr>
      -->
      <tr>
        <td>№</td>
        <td>Дисциплина</td>
        <td>Состояние</td>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(disc, index) in disciplinesStarted[1]">
        <td>{{'{{ index+1 }}'}}</td>
        <td>{{'{{ disc["DISCIPLINE"] }}'}}</td>
        <td>
          <b class="text-warning-color">Не составлялась</b>
        </td>
      </tr>
    </tbody>
  </table>
</div>