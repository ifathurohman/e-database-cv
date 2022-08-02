var host      = window.location.origin+"/e-database-cv/";

const form_riwayat   = document.querySelector("form"),
fileInput_riwayat    = document.querySelector(".file-input-riwayat"),
progressArea_riwayat = document.querySelector(".progress-area2"),
uploadedArea_riwayat = document.querySelector(".uploaded-area2");

// form click event
// form.addEventListener("click", () =>{
//   fileInput_posisi.click();
// });

fileInput_riwayat.onchange = ({target})=>{
  let file = target.files[0]; //getting file [0] this means if user has selected multiple files then get first one only
  if(file){
    let fileName = file.name; //getting file name
    if(fileName.length >= 12){ //if file name length is greater than 12 then split it and add ...
      let splitName = fileName.split('.');
      fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
    }
    uploadFileRiwayat(fileName); //calling uploadFileriwayatwith passing file name as an argument
  }
}

// file upload function
function uploadFileRiwayat(name){
  let xhr = new XMLHttpRequest(); //creating new xhr object (AJAX)
  xhr.open("POST", host + "api/upload_file/"); //sending post request to the specified URL
  $('.guide_hide2').hide(230);
  console.log(xhr);

  xhr.upload.addEventListener("progress", ({loaded, total}) =>{ //file uploading progress event
    let fileLoaded = Math.floor((loaded / total) * 100);  //getting percentage of loaded file size
    let fileTotal = Math.floor(total / 1000); //gettting total file size in KB from bytes
    let fileSize;
    let value = host + "img/icon/vscode-icons_file-type-excel.png";
    // if file size is less than 1024 then add only KB else convert this KB into MB
    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024*1024)).toFixed(2) + " MB";
    let progressHTML = `<li class="row">
                          <div class="content">
                                <header>Uploaded</header>
                                <div class="row">
                                    <div class="col-md-1">
                                      ${img = '<img src="'+value+'" width="55" style="margin-bottom: 10px;" />'}
                                    </div>
                                    <div class="col-md-11">
                                        <div class="details">
                                            <span class="name" style="font-weight: bold;">${name}<span style="font-weight: 100;margin-left:20px">${fileSize}</span></span>
                                            <span><i class="mdi mdi-check"></i></span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress" style="width: ${fileLoaded}%"></div>
                                        </div>
                                        <span class="details">
                                            <span>${fileLoaded}% done</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>`;
    // uploadedArea_posisi.innerHTML = ""; //uncomment this line if you don't want to show upload history
    // uploadedArea_posisi.classList.add("onprogress");
    progressArea_riwayat.innerHTML = progressHTML;
    // if(loaded == total){
    //   progressArea_riwayat.innerHTML = "";
    //   let uploadedHTML = `<li class="row">
    //                         <div class="content">
    //                         <header>Uploaded</header>
    //                         <div class="row">
    //                             <div class="col-md-1">
    //                               ${img = '<img src="'+value+'" width="55" style="margin-bottom: 10px;" />'}
    //                             </div>
    //                             <div class="col-md-11">
    //                                 <div class="details">
    //                                     <span class="name" style="font-weight: bold;">${name} style="font-weight: 100;margin-left:20px">${fileSize}</span></span>
    //                                     <span class="percent"><i class="mdi mdi-check"></i></span>
    //                                 </div>
    //                                 <div class="progress-bar">
    //                                     <div class="progress"></div>
    //                                 </div>
    //                                 <span class="details">
    //                                     <span>${fileLoaded}% done</span>
    //                                 </span>
    //                             </div>
    //                         </div>
    //                     </div>
    //                   </li>`;
    //   // uploadedArea_posisi.classList.remove("onprogress");
    //   // uploadedArea_posisi.innerHTML = uploadedHTML; //uncomment this line if you don't want to show upload history
    //   uploadedArea_posisi.insertAdjacentHTML("afterbegin", uploadedHTML); //remove this line if you don't want to show upload history
    // }
  });
  let data = new FormData(form_riwayat); //FormData is an object to easily send form data
  xhr.send(data); //sending form data
}


