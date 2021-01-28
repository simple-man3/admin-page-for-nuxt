export const getters={
  authCheck(state){
    return state.auth.loggedIn
  },

  authUser(state){
    return state.auth.user
  },
}
