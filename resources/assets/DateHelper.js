class DateHelper {
    /*
     * @ar1 Date object
     */
    static formateDateTime(date){
        let year = date.getFullYear();
        let month = date.getMonth()+1;
        let day = date.getDate();
        let hour = date.getHours();
        let minutes = date.getMinutes();

        if(day<10)
            day = '0'+day;
        if(month<10)
            month = '0'+month;

        return year+'-'+month+'-'+day+'-'+hour+':'+minutes;
    }
    /*
     * @ar1 Date object
     * return string
     *
     */
    static formateDate(date){
        let year = date.getFullYear();
        let month = date.getMonth()+1;
        let day = date.getDate();

        if(day<10)
            day = '0'+day;
        if(month<10)
            month = '0'+month;

        return year+'-'+month+'-'+day;
    }
    /*
     * @ar1 string with format yyyy-mm-dd
     */
    static getDateObject(date){
        let arraySliced = date.split('-')

        let day =  arraySliced[2]
        let month = arraySliced[1] - 1
        let year = arraySliced[0]

        return new Date(year,month,day,0,0);
    }
    /*
     * @ar1 string with format yyyy-mm-dd
     * dd-mm-yyyy
     */
    static formatDateToShow(date){
        return date.toString().split('-').slice(0,3).reverse().join('/');
    }
    /*
     * @arg1 int from getDay js Date Object
     */
    static getDay(day) {
        switch(day){
            case 0:
                return 'sun';
            case 1:
                return 'mon';
            case 2:
                return 'tue';
            case 3:
                return 'wed';
            case 4:
                return 'thu';
            case 5:
                return 'fri';
            case 6:
                return 'sat';
        }
    }
    /*
     * @arg1 string with format yyyy-mm-dd
     * @arg2 int with time that cycle takes to complete
     */
    static checkCycleTime(date,cycleTime){
        let dateObject = this.getDateObject(date);
        let dateLimit  = new Date(dateObject.setDate(dateObject.getDate()+cycleTime));
        let today      = new Date();

        if(today > dateLimit)
            return true;

        return false;
    }
}

window.DateHelper = DateHelper;
export default DateHelper;