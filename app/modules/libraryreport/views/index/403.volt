{{ content() }}

{% set roleSystem  = session.get('current_data')['ROLES'] %}
{% set servAdministrator = (session.get('services_admin') is empty) ? '' : session.get('services_admin')  %}

<div class="main-menu-modules-wrapper row">

      {% if not(services is empty) %}
      {% for i in 0..services|length - 1 %}

          {# проверка наличия прав администратора или супервизора #}
          {% set hasAccess = (roleSystem == 1 ? 0 : null) or (services[i]['FNREC'] in servAdministrator) %}
          {# если нет прав администратора, проверка соответствия роли #}
          {% if not(hasAccess) %}

            {# если нет ПРАВ администратора, но есть РОЛЬ администратора, то меняем роль на работника #}
            {% if (roleSystem == 2) %}
              {% set roleSystem = 7 %}
            {% endif %}

              {% for j in 0..services[i]['FCROLE_LIST']|length - 1 %}           
                  {% set hasAccess = hasAccess or ((services[i]['FCROLE_LIST'][j] == roleSystem)) %}
              {% endfor %}

          {% endif %}

          {% if hasAccess %}
            <a href="{{url(services[i]['URL'])}}">
                <div class="small-12 medium-4 large-2 columns main-menu-module">
                    <div class="main-menu-modules-img" >
                        <img src="/img/services/{{services[i]['IMGURL']}}" alt="{{services[i]['FNAME']}}">
                    </div>
                    <div class="main-menu-modules-description" >
                        {{services[i]['FNAME']}}
                    </div>
                </div>
            </a>
          {% endif %}
      {% endfor %}
    {% endif %}

</div>
