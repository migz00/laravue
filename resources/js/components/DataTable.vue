<template>
  <v-data-table
    :headers="headers"
    :items="items"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Assets</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              New Item
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form
                  ref="form"
                  v-model="valid"
                  lazy-validation
                >
                  <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="12"
                      >
                        <v-text-field
                          :readonly="edit === true"
                          :rules="ic_rules"
                          prepend-icon="mdi-barcode"
                          v-model="editedItem.item_code"
                          label="Item Code"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="12"
                      >
                        <v-text-field
                          prepend-icon="mdi-tag"
                          :rules="ic_rules"
                          v-model="editedItem.item_desc"
                          label="Item Description"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          prepend-icon="mdi-pound"
                          v-model="editedItem.qty"
                          :rules="ic_rules"
                          label="Quantity"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          prepend-icon="mdi-scale-balance"
                          v-model="editedItem.unit_of_measure"
                          :rules="ic_rules"
                          label="Unit of Measure"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          prepend-icon="mdi-currency-usd"
                          v-model="editedItem.price"
                          label="Price"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="12"
                      >
                        <v-text-field
                          prepend-icon="mdi-map-marker-outline"
                          v-model="editedItem.location"
                          label="Location"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="6"
                      >
                        <v-col
                          cols="12"
                          sm="6"
                          md="12"
                        >
                          <v-text-field
                            :disabled="editedItem.type === '0'"
                            :error-messages="s_err"
                            v-model="editedItem.serial"
                            label="Serial"
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                          sm="6"
                          md="12"
                        >
                          <v-text-field
                            :disabled="editedItem.type === '0'"
                            :error-messages="m_err"
                            v-model="editedItem.model"
                            label="Model"
                          ></v-text-field>
                        </v-col>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="6"
                      >
                        <v-radio-group v-model="editedItem.type">
                          <template v-slot:label>
                            <div><strong>Type of Asset</strong></div>
                          </template>
                          <v-radio value='0'>
                            <template v-slot:label>
                              <div><strong class="primary--text">Consumable</strong></div>
                            </template>
                          </v-radio>
                          <v-radio value='1'>
                            <template v-slot:label>
                              <div><strong class="error--text">Non-Consumable</strong></div>
                            </template>
                          </v-radio>
                        </v-radio-group>
                      </v-col>
                  </v-row>
                </v-form>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.type="{ item }">
      <div v-if="item.type == '0'">Consumable</div>
      <div v-if="item.type == '1'">Non-Consumable</div>
    </template>
    <template v-slot:item.created_at="{ item }">
      {{ new Date(item.created_at).toString().substr(0, 23) }}
    </template>
    <template v-slot:item.updated_at="{ item }">
      {{ new Date(item.updated_at).toString().substr(0, 23) }}
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <div> no data </div>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      check_val: 0,
      s_err: '',
      m_err: '',
      valid: true,
      edit: false,
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Item Code',
          align: 'start',
          sortable: false,
          value: 'item_code',
        },
        { text: 'Item Description', value: 'item_desc' },
        { text: 'Quantity', value: 'qty' },
        { text: 'Type', value: 'type' },
        { text: 'Serial', value: 'serial' },
        { text: 'Model', value: 'model' },
        { text: 'Unit of Measure', value: 'unit_of_measure' },
        { text: 'Price', value: 'price' },
        { text: 'Location', value: 'location' },
        { text: 'Created At', value: 'created_at' },
        { text: 'Updated At', value: 'updated_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      items: [],
      temp: {
        serial: '',
        model: '',
      },
      editedIndex: -1,
      editedItem: {
        item_code: '',
        item_desc: '',
        qty: 0,
        unit_of_measure: '',
        price: 0,
        location: '',
        type: '0',
        serial: '',
        model: '',
      },
      defaultItem: {
        item_code: '',
        item_desc: '',
        qty: 0,
        unit_of_measure: '',
        price: 0,
        location: '',
        type: '0',
        serial: '',
        model: '',
      },
      ic_rules: [
        v => !!v || 'Item Code is required',
      ],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
      'editedItem.type' (val) {

        if (val == '0') {
          this.editedItem.serial = ''
          this.editedItem.model = ''
          this.s_err = ''
          this.m_err = ''
        } else {
          if (this.editedItem.serial.length === 0) {
            this.s_err = "Serial is required"
          }
          if (this.editedItem.model.length === 0) {
            this.m_err = "Model is required"
          }
        }
      },
      'editedItem.serial' (val) {
        if (val) {
          this.s_err = ''
        } else {
          this.s_err = "Serial is required"
        }
      },
      'editedItem.model' (val) {
        if (val) {
          this.m_err = ''
        } else {
          this.m_err = "Model is required"
        }
      }
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        axios.get('api/home')
        .then(response => {
            console.log(response.data)
            this.items = response.data
        })
        .catch(error => {
        });
      },

      editItem (item) {
        console.log(item)
        this.edit = true
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        axios.delete('api/home/destroy/' + this.editedItem.id)
                .then(response => {
                    if ( response.status == 200 ){
                        console.log('Success')
                        this.$nextTick(() => {
                          this.editedItem = Object.assign({}, this.defaultItem)
                          this.editedIndex = -1
                        })
                        this.initialize()
                    } 
                    else 
                    {
                        console.log('Failed')
                    }
                })
                .catch(error => {

                });
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.edit = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {

          axios.put('api/home/update', {
                    item: this.editedItem
                })
                .then(response => {
                    if ( response.status == 200 ){
                        console.log('Success')
                        this.$nextTick(() => {
                          this.editedItem = Object.assign({}, this.defaultItem)
                          this.editedIndex = -1
                        })
                        this.initialize()
                    } 
                    else 
                    {
                        console.log('Failed')
                    }
                })
                .catch(error => {

                });

        } else {

          axios.post('api/home/store', {
                    item: this.editedItem
                })
                .then(response => {
                    if ( response.status == 201 ){
                        console.log('Success')
                        this.$nextTick(() => {
                          this.editedItem = Object.assign({}, this.defaultItem)
                          this.editedIndex = -1
                        })
                        this.initialize()
                    } 
                    else 
                    {
                        console.log('Failed')
                    }
                })
                .catch(error => {

                });

        }
        this.close()
      },
    },
  }
</script>