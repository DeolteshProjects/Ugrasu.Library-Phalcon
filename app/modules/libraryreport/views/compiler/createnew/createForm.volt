<!-- Тело модуля -->
<div class="">
  <!-- Форма поиска -->
  <div class="block-create-form columns main-menu-module">
    <div class="form">
      <div class="form-title">
        <h5>Форма создания новой библиографической справки</h5>
      </div>
      <div class="column small-12 medium-3 large-3">
        <!-- Год набора -->
          <label class="select">Год набора</label>
          <select v-model="changed.year" class="select" v-on:change="changeYear()">
            <template v-if="years !== null">
              <template v-for="year in years">
                <option :value="year">{{'{{ year }}'}} - {{'{{ year + 1 }}'}}</option>
              </template>
            </template>
          </select>
      </div>

      <div class="column small-12 medium-6 large-6">
        <!-- Направление обучения -->
          <label class="select">Направление обучения</label>
          <select v-model="changed.speccode" class="select" v-on:change="changeSpec()">
            <template v-if="specialitys !== null">
              <template v-for="(spec, index) in specialitys">
                <option :value="index">{{'{{ spec.FSPECIALITYCODE }}'}} | {{'{{ spec.SPECIALITY }}'}}
                </option>
              </template>
            </template>
          </select>
      </div>

      <div class="column small-12 medium-3 large-3">
        <!-- Форма обучения -->
          <label class="select">Форма обучения</label>
          <select v-model="changed.forma" class="select" v-on:change="changeForm()">
            <template v-if="forms !== null">
              <template v-for="form in forms">
                <option :value="form.FORMA">{{'{{ form.FORMA }}'}} </option>
              </template>
            </template>
          </select>
      </div>

      <div class="col-md-12" v-if="forma != null">
        <button v-on:click="getEmpty()" class="col-md-12 btn btn-lg btn-success" name="literatureSearch">Загрузить дисциплины</button>
      </div>
    </div>
  </div>
</div>