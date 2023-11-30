import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:8000/api/",
});

const limparClearInterval = (config) => {

    if ((config.url !== '/comandas/mesa/itens' && !config.url.includes('itens_comandas') &&
            (config.url !== "/comandas/mesa/notificacoes" && (config.url !== "/administrativo")))) {
        console.log(config.url)
        console.log("LIMPANDO CLEAR INTERVAL")
        for (let i = 0; i < 100; i++) {
            window.clearInterval(i);
        }
    }
}

api.interceptors.request.use(
    function(config) {
        limparClearInterval(config)
        return config;
    },
    function(error) {
        return Promise.reject(error);
    }
);

// api.interceptors.request.use(
//     (config) => {
//         config.headers.Authorization = `Bearer ${token}`;

//         return config;
//     },
//     (error) => {
//         return Promise.reject(error);
//     }
// );


export default api