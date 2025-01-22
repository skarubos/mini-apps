// レシピタイプ選択ボタンの処理
const allinSelector = document.getElementById("allin-selector");
const imageSelector = document.getElementById("image-selector");
const urlSelector = document.getElementById("url-selector");
const recipeType = document.querySelector('#recipe-type');
const howmanyInput = document.querySelector('input[name="howmany"]');
const recipeImageFullInput = document.querySelector('input[name="recipe-image-full"]');
const recipeUrlInput = document.querySelector('input[name="recipe-url"]');
const detailContainer = document.getElementById("detail-container");
const hUrl = document.getElementById("h-url");
const hImg = document.getElementById("h-img");

const buttons = document.querySelectorAll('.type-item');
buttons.forEach(button => {
  button.addEventListener('click', event => {
    const targetClassList = event.target.classList;
    if (targetClassList.contains('type-allin')) {
      allinSelector.classList.add("pressed");
      imageSelector.classList.remove("pressed");
      urlSelector.classList.remove("pressed");
      recipeType.value = 'allin';
      howmanyInput.required = true;
      recipeImageFullInput.removeAttribute('required');
      recipeUrlInput.removeAttribute('required');
      detailContainer.classList.remove("hidden");
      hUrl.classList.add("hidden");
      hImg.classList.add("hidden");
    } else if (targetClassList.contains('type-image')) {
      imageSelector.classList.add("pressed");
      allinSelector.classList.remove("pressed");
      urlSelector.classList.remove("pressed");
      recipeType.value = 'img';
      recipeImageFullInput.required = true;
      howmanyInput.removeAttribute('required');
      recipeUrlInput.removeAttribute('required');
      hImg.classList.remove("hidden");
      hUrl.classList.add("hidden");
      detailContainer.classList.add("hidden");
    } else if (targetClassList.contains('type-url')) {
      urlSelector.classList.add("pressed");
      imageSelector.classList.remove("pressed");
      allinSelector.classList.remove("pressed");
      recipeType.value = 'url';
      recipeUrlInput.required = true;
      howmanyInput.removeAttribute('required');
      recipeImageFullInput.removeAttribute('required');
      hUrl.classList.remove("hidden");
      hImg.classList.add("hidden");
      detailContainer.classList.add("hidden");
    }
  });
});



// 「食材・分量」の入力欄を追加　&　削除ボタンを一番下の列にのみ追加
  function addRemoveButton(materialWrapper) {
    let removeButton = document.createElement('button');
    removeButton.className = 'delete-button';
    removeButton.textContent = '×';
    removeButton.addEventListener('click', function() {
        materialWrapper.remove();
        updateRemoveButtons();
    });
    materialWrapper.appendChild(removeButton);
}

function updateRemoveButtons() {
    let materialWrappers = document.querySelectorAll('.material-wrapper');
    materialWrappers.forEach(function(materialWrapper, index) {
        let removeButton = materialWrapper.querySelector('button');
        if (index === materialWrappers.length - 1) {
            if (!removeButton) {
                addRemoveButton(materialWrapper);
            }
        } else {
            if (removeButton) {
                removeButton.remove();
            }
        }
    });
}

updateRemoveButtons();

document.querySelector('#add-material').addEventListener('click', function() {
    let materialWrappers = document.querySelectorAll('.material-wrapper');
    let lastMaterialWrapper = materialWrappers[materialWrappers.length - 1];
    let newMaterialWrapper = document.createElement('div');
    newMaterialWrapper.className = 'material-wrapper';
    
    let newMaterialInput = document.createElement('input');
    newMaterialInput.type = 'text';
    newMaterialInput.className = 'input-material';
    newMaterialInput.name = 'dmat' + (materialWrappers.length + 1);
    
    let newAmountInput = document.createElement('input');
    newAmountInput.type = 'text';
    newAmountInput.className = 'input-amount';
    newAmountInput.name = 'damo' + (materialWrappers.length + 1);
    
    newMaterialWrapper.appendChild(newMaterialInput);
    newMaterialWrapper.appendChild(newAmountInput);
    
    lastMaterialWrapper.parentNode.insertBefore(newMaterialWrapper, lastMaterialWrapper.nextSibling);
    
    updateRemoveButtons();
});



// 「作り方」の入力欄を追加　&　削除ボタンを一番下の列にのみ追加
function addStepRemoveButton(inputElement) {
    let removeButton = document.createElement('button');
    removeButton.className = 'delete-button';
    removeButton.textContent = '×';
    removeButton.addEventListener('click', function() {
        let inputElements = document.querySelectorAll('.input-step');
        let lastInputElement = inputElements[inputElements.length - 1];
        lastInputElement.remove();
        removeButton.remove();
        updateStepRemoveButtons();
    });
    inputElement.parentNode.insertBefore(removeButton, inputElement.nextSibling);
}

function updateStepRemoveButtons() {
    let inputElements = document.querySelectorAll('.input-step');
    inputElements.forEach(function(inputElement, index) {
        let removeButton = inputElement.nextSibling;
        if (index === inputElements.length - 1) {
            if (!removeButton || removeButton.tagName !== 'BUTTON') {
                addStepRemoveButton(inputElement);
            }
        } else {
            if (removeButton && removeButton.tagName === 'BUTTON') {
                removeButton.remove();
            }
        }
    });
}

updateStepRemoveButtons();

document.querySelector('#add-step').addEventListener('click', function() {
    let inputElements = document.querySelectorAll('.input-step');
    let lastInputElement = inputElements[inputElements.length - 1];
    let newInputElement = document.createElement('input');
    newInputElement.type = 'text';
    newInputElement.className = 'input-step';
    newInputElement.name = 'step' + (inputElements.length + 1);
    
    lastInputElement.parentNode.insertBefore(newInputElement, lastInputElement.nextSibling);
    
    updateStepRemoveButtons();
});



  //戻るボタンが押されたときの処理
  document.getElementById("return-button").addEventListener("click", function(event) {
    event.preventDefault();
    window.history.back();
  });