<template>
    <b-button
            label="Open Uploads"
            type="is-primary"
            size="is-small"
            @click="openUploads" />


</template>

<script>
    const ModalForm = {
        props: ['uploads'],
        template: `
            <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Login</p>
                        <button
                            type="button"
                            class="delete"
                            @click="$emit('close')"/>
                    </header>
                    <section class="modal-card-body">
                        <div class="picture-container" v-for="picture in uploads">
                            <img :src="picture" alt="Image">
                        </div>
                    </section>

                </div>
        `
    }
    export default {
        name: "OpenUploads",
        props: ['uploads'],
        data() {
            return {
                isCardModalActive: false,
                loading: true
            }
        },
        mounted() {
            console.log('mounted open uplaods : ' , this.uploads);
        },
        methods: {
            openUploads() {
                let pictures = [];
                for (let picture of this.uploads) {
                    if (picture.indexOf('https') === -1) {
                        picture = picture.substring(picture.indexOf('/var/www/public/') + 16 , picture.length );
                    }
                    pictures.push(picture);
                }
                console.log('uploads to pass : ' , pictures);
                const data = {
                    'uploads': pictures
                };
                this.$buefy.modal.open({
                    parent: this,
                    component: ModalForm,
                    hasModalCard: true,
                    customClass: 'custom-class custom-class-2',
                    trapFocus: true,
                    props: data
                })
            },
            constructPicture(picture) {
                return picture.substring(picture.indexOf('/var/www/public/') + 16 , picture.length );
            }
        }
    }
</script>

<style scoped>

</style>