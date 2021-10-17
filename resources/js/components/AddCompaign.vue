<template>
    <form id="createCompaignForm" method="post" action="#">
        <b-field label="Name"
                 :type="nameValidatorType"
                 :message="nameValidatorMessage">
            <b-input type="text"
                     maxlength="30"
                     name="name"
                     v-model="name">
            </b-input>
        </b-field>

        <b-field label="From">
            <b-datetimepicker
                    v-model="from"
                    rounded
                    name="from_date"
                    placeholder="Click to select..."
                    icon="calendar-today"
                    :icon-right="from ? 'close-circle' : ''"
                    icon-right-clickable
                    @icon-right-click="clearFrom"
                    :locale="locale"
                    :datepicker="{ showWeekNumber }"
                    :timepicker="{ enableSeconds, hourFormat }"
                    horizontal-time-picker>
            </b-datetimepicker>
        </b-field>

        <b-field label="To">
            <b-datetimepicker
                    v-model="to"
                    rounded
                    placeholder="Click to select..."
                    icon="calendar-today"
                    :icon-right="to ? 'close-circle' : ''"
                    icon-right-clickable
                    @icon-right-click="clearTo"
                    :locale="locale"
                    :datepicker="{ showWeekNumber }"
                    :timepicker="{ enableSeconds, hourFormat }"
                    horizontal-time-picker
                    name="to_date">
            </b-datetimepicker>
        </b-field>

        <b-field label="Daily Budget"
                 :type="dailyBudgetValidatorType"
                 :message="dailyBudgetValidatorMessage">
            <b-input type="number" step="0.01"
                     v-model="daily_budget"
                     name="daily_budget">
            </b-input>
        </b-field>

        <b-field>
            <b-upload v-model="dropFiles"
                      multiple
                      drag-drop
                      name="images" @input="postAvatar(dropFiles)">
                <section class="section">
                    <div class="content has-text-centered">
                        <p>
                            <b-icon
                                    icon="upload"
                                    size="is-large">
                            </b-icon>
                        </p>
                        <p>Drop your files here or click to upload</p>
                    </div>
                </section>
            </b-upload>
        </b-field>
        <div class="tags">
            <span v-for="(file, index) in dropFiles"
                  :key="index"
                  class="tag is-primary" >
                {{file.name}}
                <button class="delete is-small"
                        type="button"
                        @click="deleteDropFile(index)">
                </button>
            </span>
        </div>

        <div>
            <b-button :loading="loading" size="is-small" type="is-primary" @click="createCompaign($event)">
                Create
            </b-button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "AddCompaign",
        data() {
            return {
                name: '',
                from: new Date(),
                to: new Date(),
                daily_budget: 0,
                dropFiles: [],
                nameValidatorType: '',
                nameValidatorMessage: '',

                fromValidatorType: '',
                fromValidatorMessage: '',

                toValidatorType: '',
                toValidatorMessage: '',

                dailyBudgetValidatorType: '',
                dailyBudgetValidatorMessage: '',


                showWeekNumber: false,
                enableSeconds: false,
                hourFormat: undefined, // Browser locale
                locale: undefined, // Browser locale
                loading: false,
                fileData: {}
            }
        },
        methods: {
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            },
            clearFrom () {
                this.from = null
            },
            clearTo () {
                this.from = null
            },
            createCompaign(event) {
                event.preventDefault()
                this.submitCompaign()
            },
            postAvatar(files) {
                this.fileData = new FormData()
                this.fileData.append('files', files);
                console.log('called post avatar : ' , this.fileData , files , this.dropFiles);
            },
            submitCompaign() {
                this.loading = true
                const startDate = new Date(this.from);
                const endDate = new Date(this.to);
                const from_date = startDate.getFullYear() + '-' +
                    (startDate.getMonth() < 10 ? '0' + startDate.getMonth() : startDate.getMonth()) + '-' +
                    (startDate.getDate() < 10 ? '0' + startDate.getDate() : startDate.getDate()) + ' ' +
                    (startDate.getHours() < 10 ? '0' + startDate.getHours() : startDate.getHours()) + ':' +
                    (startDate.getMinutes() < 10 ? '0' + startDate.getMinutes() : startDate.getMinutes()) + ':' +
                    (startDate.getSeconds() < 10 ? '0' + startDate.getSeconds() : startDate.getSeconds());

                const to_date = endDate.getFullYear() + '-' +
                    (endDate.getMonth() < 10 ? '0' + endDate.getMonth() : endDate.getMonth()) + '-' +
                    (endDate.getDate() < 10 ? '0' + endDate.getDate() : endDate.getDate()) + ' ' +
                    (endDate.getHours() < 10 ? '0' + endDate.getHours() : endDate.getHours()) + ':' +
                    (endDate.getMinutes() < 10 ? '0' + endDate.getMinutes() : endDate.getMinutes()) + ':' +
                    (endDate.getSeconds() < 10 ? '0' + endDate.getSeconds() : endDate.getSeconds());

                console.log('dropfiles to send : ' , this.dropFiles);
                const files = {
                    'files' : this.dropFiles
                };
                let data = new FormData()
                // data.append('files', this.dropFiles);
                for( var i = 0; i < this.dropFiles.length; i++ ){
                    let file = this.dropFiles[i];
                    data.append('files[' + i + ']', file);
                }
                axios({
                    method: 'POST',
                    url: `/compaign?name=${this.name}&from=${from_date}&to=${to_date}&daily_budget=${this.daily_budget}`,
                    data: data
                }).then(({data}) => {
                    this.loading = false;
                    window.location.href = '/compaign';
                }).catch( ( error ) => {
                    console.log( error );
                    this.loading = false;
                } );
            }
        }
    }
</script>

<style scoped>

</style>