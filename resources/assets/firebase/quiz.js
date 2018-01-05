import firebase from 'firebase';

let config = {
    apiKey: "AIzaSyB83GHmCLmsTZRfhOaaNsL4wVy470brLyc",
    authDomain: "iesb-quiz.firebaseapp.com",
    databaseURL: "https://iesb-quiz.firebaseio.com",
    projectId: "iesb-quiz",
    storageBucket: "",
    messagingSenderId: "161618805464"
};

let FbApp = firebase.initializeApp(config,'third');
window.firebaseQuiz = FbApp.database();

export default firebaseQuiz;
