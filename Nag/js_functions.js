


function XHRpost(month,year,client_type)
{
  //alert(arguments[0]+"__"+arguments[1]+"__"+arguments[2]);

  var isconf = confirm(`send asynchronic XMLHttp Request to database ?`); //request confirmation
  if (!isconf) //if answer CANCEL
  {
    //alert('did not');
  }
  else // ELSE: if answer = OK
  {

    // 1. Создаём новый XMLHttpRequest-объект
    let xhr = new XMLHttpRequest();

    // 2. Настраиваем его
    xhr.open('POST', `response.php?m=${month}&y=${year}&ct=${client_type}`, true);

    // 3. Отсылаем запрос
    xhr.send();

    // 4. Этот код сработает после того, как мы получим ответ сервера
    xhr.onload = function() 
    {
      if (xhr.status != 200) // анализируем HTTP-статус ответа, если статус не 200, то произошла ошибка
      { 
        alert(`Ошибка ${xhr.status}: ${xhr.statusText}`); // Например, 404: Not Found
      } 
      
      else // если всё прошло гладко, выводим результат
      { 
        //alert(`Готово, получили ${xhr.response.length} байт`); // response -- это ответ сервера
        document.getElementById('results').innerHTML = (`<br><span><i>************ here is your response ************</i></span><br><span>Год ${year} - Месяц ${month}</span><br>`
                    +`${xhr.responseText}`);

      } 
    };

    xhr.onerror = function() //  ЕСЛИ ОШИБКА ДО ПОЛУЧЕНИЯ ОТВЕТА
    {
      alert("Запрос не удался");
    };

    
    xhr.onreadystatechange = function() 
    // ------- ЕСЛИ state='request finished and response is ready' & status='OK' ----------
    {
      if (this.readyState == 4 && this.status == 200) 
      {

      }

    }

  } // ELSE: if answer = OK
} //END OF FUNCTION
//*****************************************************************************************************
