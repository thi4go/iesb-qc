import firebase from 'firebase';

let config = {
    apiKey: "AIzaSyCXJmEXz7eP2vv7ehCM9G7VKplWbqg2nAs",
    authDomain: "question-iesb.firebaseapp.com",
    databaseURL: "https://question-iesb.firebaseio.com",
    projectId: "question-iesb",
    storageBucket: "",
    messagingSenderId: "607089385634"
};

let UserQuestionFB = firebase.initializeApp(config, 'secondary');

window.FirebaseUserQuestions = UserQuestionFB.database();

export default FirebaseUserQuestions;
