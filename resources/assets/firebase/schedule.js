import firebase from 'firebase';

let config = {
    apiKey: "AIzaSyAD-EqMPWrs8_iy0rMs8jr-U5YZMD2puvQ",
    authDomain: "controle-iesb.firebaseapp.com",
    databaseURL: "https://controle-iesb.firebaseio.com",
    projectId: "controle-iesb",
    storageBucket: "",
    messagingSenderId: "1000136630664"
};

let FbApp = firebase.initializeApp(config);
window.firebaseSchedule = FbApp.database();

export default firebaseSchedule;
