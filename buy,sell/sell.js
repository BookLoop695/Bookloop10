const firebaseConfig = {
  apiKey: "AIzaSyD03M6ZWuavS1KGuVpnyev6h81O3KXel-8",
  authDomain: "bookloop-sell.firebaseapp.com",
  databaseURL: "https://bookloop-sell-default-rtdb.firebaseio.com",
  projectId: "bookloop-sell",
  storageBucket: "bookloop-sell.appspot.com",
  messagingSenderId: "247563240573",
  appId: "1:247563240573:web:bb1895e89a1acf708d1d14",
  measurementId: "G-Z00HYDGBN8"
};

  //initialize database 
  firebase.initializeApp(firebaseConfig);

  //refrence database
  var form1DB = firebase.database().ref("sellform")
  
  
  document.getElementById("sellform").addEventListener("submit",submitForm);
  
  function submitForm(e){
    e.preventDefault();

    var Title = getElementval('title');
    var Author = getElementval('author');
    var Category = getElementval('Category');
    var Published = getElementval('published');
    var Method = getElementval('Method');
    var Pricetype = getElementval('Pricetype');
    var Price = getElementval('Price');
    var Condition = getElementval('Condition');
    var textarea = getElementval('textarea');
    var mobilenumber = getElementval('mobilenumber');
    




    saveMessages(Title,Author,Category,Published,Method,Pricetype,Price,Condition,mobilenumber);

    

  }
  function uploadimage(){
    const ref = firebase.storage("sellform").ref("sellform")

    const file = document.querySelector('#photo').files[0]

    const name = new Date() + '-' + file.name

    const metadata={
      contentType:file.contentType
    }

    const task = ref.child(name).put(file,metadata)

    task 
    .then(snapshot => snapshot.ref.getdownloadURL())
    .then(url => {
      console.log(url)
      alert("imageupload successful")
    })
  }


    const saveMessages = (Title,Author,Category, published,Method,Pricetype,Price,Condition) => {
    var form1 = form1DB.push();

    form1.set({
      Title : Title,
      Author : Author,
      category : Category,
      published :  published,
      Method : Method,
      Pricetype : Pricetype ,
      Price : Price,
      Condition :Condition,
      textarea : textarea ,
      mobilenumber : mobilenumber,




    });
  };


  const getElementval = (id) => {
    return document.getElementById(id).value;

  };
