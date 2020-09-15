var app = new Vue({
  el: '#app',
  data: {
    selected: {
      number_azs: null,
      region_azs: null,
      city_azs: null,
      street_azs: null,
    },
    formLists: {
      number_azs: [],
      region_azs: [],
      city_azs: [],
      street_azs: [],
    },
    show: {
      number_azs: null,
      region_azs: null,
      city_azs: null,
      street_azs: null,
    }
  },

  methods: {
    // фокус или изменения инпута формы
    changeInput: async function (event) {
      let response = await fetch('/webform', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify({
          selected: this.selected,
          name: event.target.name,
        })
      })

      let result = await response.json()
      let column = []
      if (result.count > 1) {
        result.data.forEach(function (val) {
          column.push(val[event.target.name])
        })
        if (result.data.length === 1) {
          this.selected[event.target.name] = result.data[0][event.target.name]
        } else {
          this.formLists[event.target.name] = column
          this.show[event.target.name] = true
        }
      } else if (result.count == 1) {
        this.selected = result.data[0]
      }
    },
    // клик по значению в списке
    selectValue: function (val, name) {
      this.selected[name] = val
      this.show[name] = false
    },
    // закрытие списка значений
    closeList: function (name) {
      this.show[name] = false
    },
    resetForm: function () {
      this.selected = {
        number_azs: null,
        region_azs: null,
        city_azs: null,
        street_azs: null,
      }
    }
  }

})
