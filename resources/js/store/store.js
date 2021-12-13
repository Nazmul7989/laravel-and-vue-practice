import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)



export const store = new Vuex.Store({
    state: {
        students: [],
    },
    getters: {
        getStudents(state){
           return state.students;
        }
    },
    mutations: {
        SET_STUDENTS(state, data){
            state.students = data;
        }
    },
    actions: {
        loadStudents(context){
            axios.get('/students').then((response)=>{
                console.log(response.data)
                context.commit('SET_STUDENTS', response.data);
            }).catch((error)=>{
                console.log(error);
            })
        }
    }
});
