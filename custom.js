// setTimeout(() => {
//   var anchorElement = document.querySelector('a.x-anchor[href="https://mainecleanenergyjobs.com/job-posting/"]');
// if (anchorElement) {
//     anchorElement.href = 'https://mainecleanenergyjobs.com/employer-posting-form/';
//     // console.log("Href changed successfully!");
// } 
// }, 1000);


  var inputElement1 = document.querySelector(
    '.side_filtr.Gid.modernization.storage input[value="Gid modernization + storage"]'
  );
  if (inputElement1) {
    var labelElement1 = inputElement1.parentNode.querySelector("label");

    if (labelElement1) {
      labelElement1.textContent = "Clean Grid & Storage";
    }
  }

