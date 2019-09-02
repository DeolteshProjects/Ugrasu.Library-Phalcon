<div class="small-12 medium-12 large-12 columns">
  <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
  <table cellspacing="0">
    <thead class="btn-success">
      <tr>
        <th>№</th>
        <th>Дисциплина</th>
        <th>Состояние</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(list, index) in listEmpty[0]">
        <td>{{'{{ index+1 }}'}}</td>
        <td>{{'{{ list["DISCIPLINE"] }}'}}</td>
        <td class="text-info-color" v-if="list['STATUS'] == 0">
            <b>Новая</b>
        </td>
        <td class="text-danger-color" v-if="list['STATUS'] == 2">
            <b>Отклонена библиотекой</b>
        </td>
        <td class="text-secondary-color" v-if="list['STATUS'] == 8">
            <b>Исправлена</b>
        </td>
        <td class="text-success-color" v-if="list['STATUS'] == 10">
          <b>Принята библиотекой</b>
        </td>
        <td>
          <button class="btn btn-lg btn-info col-md-12" @click="getReport(list['UCD_FNREC'])">Открыть</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>