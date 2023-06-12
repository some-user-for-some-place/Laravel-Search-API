<template>
    <div>
            <form @submit.prevent="searchHomes" class="search-form">
                <div class="row-cols-4 fw-bold" style="width: 92%">
                    <label class="form-label mx-2 fs-4 mb-3" for="name">Название:</label>
                    <input class="input-group-text mx-2 px-4 border-4" type="text" id="name" v-model="search.name" list="name-list">

                    <datalist id="name-list">
                        <option v-for="option in nameOptions" :value="option">{{ option }}</option>
                    </datalist>

                    <br>


                    <label class="form-label mx-2 fs-4 mb-3" for="bedrooms">Количество спален:</label>
                    <input class="input-group-text mx-2 px-2 border-4" type="number" id="bedrooms" v-model.number="search.bedrooms" list="bedrooms-list">

                    <datalist id="bedrooms-list">
                        <option v-for="option in bedroomsOptions" :value="option">{{ option }}</option>
                    </datalist>
                    <br>

                    <label class="form-label mx-2 fs-4 mb-3" for="bathrooms">Количество ванных комнат:</label>
                    <input class="input-group-text mx-2 px-2 border-4" type="number" id="bathrooms" v-model.number="search.bathrooms" list="bathrooms-list">

                    <datalist id="bathrooms-list">
                        <option v-for="option in bathroomsOptions" :value="option">{{ option }}</option>
                    </datalist>
                    <br>

                    <label class="form-label mx-2 fs-4 mb-3" for="storeys">Количество этажей:</label>
                    <input class="input-group-text mx-2 px-2 border-4" type="number" id="storeys" v-model.number="search.storeys" list="storeys-list">

                    <datalist id="storeys-list">
                        <option v-for="option in storeysOptions" :value="option">{{ option }}</option>
                    </datalist>
                    <br>

                    <label class="form-label mx-2 fs-4 mb-3" for="garages">Количество гаражей:</label>
                    <input class="input-group-text mx-2 px-2 border-4" type="number" id="garages" v-model.number="search.garages" list="garages-list">

                    <datalist id="garages-list">
                        <option v-for="option in garagesOptions" :value="option">{{ option }}</option>
                    </datalist>
                    <br>

                    <div class="d-inline">
                        <label class="form-label mx-2 fs-4 mb-3" for="price_min, price_max">Цена (диапазон $X — $Y):</label>
                        <br>
                        <input class="input-group-text mx-2 border-4 d-inline-block" type="number" id="price_min" v-model.number="search.price_min" placeholder="От">
                        <p class="d-inline-block fs-5"> — </p>
                        <input class="input-group-text mx-2 border-4 d-inline-block" type="number" id="price_max" v-model.number="search.price_max" placeholder="До">
                    </div>
                    <br><br>

                    <button class="btn btn-outline-primary mx-2 fs-5 mb-3 fw-bold" style="width: 10%;" type="submit">Найти</button>
                    <div class="spinner-border" v-if="loading"></div>
                </div>
                <hr>

            </form>

            <table v-if="homes.length" class="table table-bordered table-hover">
                <thead class="table-light fw-bold fs-4">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество спален</th>
                    <th>Количество ванных комнат</th>
                    <th>Количество этажей</th>
                    <th>Количество гаражей</th>
                </tr>
                </thead>
                <tbody class="table-secondary fs-5">
                <tr v-for="home in homes" :key="home.id">
                    <td>{{ home.id }}</td>
                    <td>{{ home.name }}</td>
                    <td>{{ home.price }}</td>
                    <td>{{ home.bedrooms }}</td>
                    <td>{{ home.bathrooms }}</td>
                    <td>{{ home.storeys }}</td>
                    <td>{{ home.garages }}</td>
                </tr>
                </tbody>
            </table>

            <p v-else class="mx-2 fs-4 mb-3">
                <span class="text-danger text-bg-dark">Запись по соответствующим фильтрам не найдена</span>
                или
                <span class="text-warning text-bg-dark">Вы не выполнили поиск.</span>
            </p>
        </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            homes: [],
            search: {
                name: "",
                bedrooms: null,
                bathrooms: null,
                storeys: null,
                garages: null,
                price_min: null,
                price_max: null,
            },
            loading: false,
            nameOptions: [], // массив данных для выпадающего меню
            bedroomsOptions: [], // массив данных для выпадающего меню
            bathroomsOptions: [], // массив данных для выпадающего меню
            storeysOptions: [],
            garagesOptions: []
        };
    },
    mounted() {
        const options = [
            { name: 'nameOptions', param: 'name' },
            { name: 'bedroomsOptions', param: 'bedrooms' },
            { name: 'bathroomsOptions', param: 'bathrooms' },
            { name: 'storeysOptions', param: 'storeys' },
            { name: 'garagesOptions', param: 'garages' },
        ];

        options.forEach(({ name, param }) => {
            axios
                .get(`/api/v1/homes?per_page=10000&${param}=true`)
                .then((response) => {
                    const values = [...new Set(response.data.data.map((home) => home[param]))];
                    this[name] = values;
                })
                .catch((error) => {
                    console.error(error);
                });
        });
    },
    methods: {
        searchHomes() {
            this.loading = true;
            axios
                .get("/api/v1/homes", {
                    params: {
                        per_page: 10000,
                        name: this.search.name,
                        bedrooms: this.search.bedrooms,
                        bathrooms: this.search.bathrooms,
                        storeys: this.search.storeys,
                        garages: this.search.garages,
                        price_min: this.search.price_min,
                        price_max: this.search.price_max,
                        ...this.getFilterParams(),
                    },
                })
                .then((response) => {
                    console.log(response.data);
                    this.homes = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        getFilterParams() {
            let params = {};
            for (let filter in this.search) {
                if (this.search[filter] !== null && this.search[filter] !== "") {
                    let operator = null;
                    if (filter === "name") {
                        operator = "like";
                        params[`${filter}[${operator}]`] = `%${this.search[filter]}%`;
                    } else {
                        operator = "eq";
                        params[`${filter}[${operator}]`] = this.search[filter];
                    }
                }
            }
            if (this.search.price_min !== null && this.search.price_min !== "") {
                params["price[range]"] = `${this.search.price_min},${this.search.price_max}`;
            } else if (this.search.price_max !== null && this.search.price_max !== "") {
                params["price[range]"] = `,${this.search.price_max}`;
            }

            return params;
        },
    },
};
</script>
