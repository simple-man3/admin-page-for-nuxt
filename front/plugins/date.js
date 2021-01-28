export default ({ app }, inject) => {
  inject('formatDate', (date) => {
    // console.log(date);
    let d = new Date(date);
    console.log(
      new Date(date)
    );

    let day = d.getDate() < 9 ? "0" + d.getDate() : d.getDate();
    let month =
      d.getMonth() + 1 < 9
        ? "0" + (d.getMonth() + 1)
        : d.getMonth() + 1;
    let year = d.getFullYear();

    // console.log(
    //   'hour: '+d.getHours()+'\n'+
    //   'minute: '+d.getMinutes()
    // );

    let hour=(d.getHours()!=0)?
      ()=>{
        if (d.getHours()<=9) {
          return `0${d.getHours()}`
        } else {
          return true;
        }
      }:
      ()=>'00';

    let customDate = day + "." + month + "." + year;
    let customTime = hour();


    // return `${customDate} ${customTime}:`;
  })
}
