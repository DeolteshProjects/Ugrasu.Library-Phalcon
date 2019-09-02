<!-- Панель сохранения справки-->

<div>
  <template v-if="danger != null">
    <label>Укажите причину отклонения: <b class="text-danger-color">{{'{{ alertMessage }}'}}</b></label>
    <input v-model="dangerMessage" type="text">
  </template>
</div>

<div>
  <button @click="successReport(report[0]['UCD_FNREC'])" v-if="(report[0]['STATUS']) < 10"
    class="btn btn-success">Принять</button>
  <button @click="dangerReport(report[0]['UCD_FNREC'])" v-if="(report[0]['STATUS']) != 2"
    class="btn btn-danger">Отклонить</button>
  <button class="btn btn-info" @click="getReports(report[0]['YEARED'], report[0]['SPECIALITYCODE'], report[0]['FORMA'])">Перейти к другим справкам по этому направлению</button>
</div>