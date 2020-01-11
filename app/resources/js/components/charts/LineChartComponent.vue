<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <line-chart :chart-data="data" :height="100" :options="{responsive: true, maintainAspectRation: true}"></line-chart>
                <button class="btn btn-primary btn-sm" @click="update">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
    import LineChart from "../chartsjs/LineChart";
export default {
    components: {
      LineChart
    },
    data: function() {
      return {
          data: []
      };
    },
    methods: {
        update: function () {
            axios.get('/charts/liner-chart').then(response => {
                this.data = response.data;
            })
        }
    },
    mounted() {
        this.update();
    }
}
</script>
