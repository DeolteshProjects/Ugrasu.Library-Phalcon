<div class="small-12 medium-12 large-12 columns">
  <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
  <table cellspacing="0">
    <thead class="btn-danger">
      <tr>
        <th>№</th>
        <th>Дисциплина</th>
        <th>Состояние</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(list, index) in listEmpty[2]">
        <td>{{'{{ index+1 }}'}}</td>
        <td>{{'{{ list["DISCIPLINE"] }}'}}</td>
        <td class="text-danger-color">
            <b>Отклонена библиотекой</b>
        </td>
        <td>
          <button class="btn btn-lg btn-info col-md-12" @click="getReport(list['UCD_FNREC'])">Открыть</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>