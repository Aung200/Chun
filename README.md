<html>
  <head>
    <title>A1-T01-1051738(Phyo)</title>
    <style>
      .table-header {
        background-color: rgb(209, 238, 255);
        padding: 12px;
        font-size: 25px;
      }
      td {
        padding: 12px;
      }
      .errorMessage {
        color: red;
      }
      .part2-table {
        padding: 20px 0px;
      }
      input {
        padding: 7px;
        border-radius: 5px;
      }
      button {
        padding: 5px;
        border-radius: 5px;
      }
    </style>
    <script>
      function getCurrentDate() {
        var dayArray = [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        var monthArray = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];
        //13 July 2024 Saturday 1:47 PM
        var currentDate = new Date();
        var date = currentDate.getDate().toString();
        var month = monthArray[currentDate.getMonth()];
        var year = currentDate.getFullYear().toString();
        var day = dayArray[parseInt(currentDate.getDay())];
        var hour = currentDate.getHours();
        hour = hour % 12;
        hour = (hour ? hour : 12).toString();
        var minute = currentDate.getMinutes();
        minute = (minute < 10 ? "0" + minute : minute).toString();
        var ampm = currentDate.getHours() >= 12 ? "PM" : "AM";
        var newTime =
          date +
          " " +
          month +
          " " +
          year +
          " " +
          day +
          " " +
          hour +
          ":" +
          minute +
          " " +
          ampm;
        document.getElementById("date").value = newTime;
      }
      window.onload = getCurrentDate; // ✅ correct
      // window.onload = getCurrentDate(); ❌ wrong — this runs the function too early
      function checkName() {
        var value = document.getElementById("name").value;
        if (value == null || value.trim() == "") {
          document.getElementById("nameError").innerHTML =
            "Name must be filled out!";
        } else {
          if (/^[A-Za-z\s]+$/.test(value) == false) {
            document.getElementById("nameError").innerHTML =
              "Input does not match the pattern!";
          } else {
            document.getElementById("nameError").innerHTML = "";
          }
        }
      }
      function checkModule() {
        var value = document.getElementById("module").value;
        if (value == null || value.trim() == "") {
          document.getElementById("moduleError").innerHTML =
            "Module code must be filled out!";
        } else {
          if (/^[A-Z]{3}[0-9][5-8]{2}$/.test(value) == false) {
            document.getElementById("moduleError").innerHTML =
              "Input does not match the pattern!";
          } else {
            document.getElementById("moduleError").innerHTML = "";
          }
        }
      }
      function checkMessage() {
        var value = document.getElementById("message").value;
        if (value == null || value.trim() == "") {
          document.getElementById("messageError").innerHTML =
            "Message must be filled out!";
        } else {
          document.getElementById("messageError").innerHTML = "";
        }
      }
      function findMessage() {
        var value = document.getElementById("find").value;
        if (value == null || value.trim() == "") {
          document.getElementById("replace").disabled = true;
        } else {
          document.getElementById("replace").disabled = false;
        }
      }
      function handleReplace() {
        var messageElement = document.getElementById("message");
        var findValue = document.getElementById("find").value;
        var replaceValue = document.getElementById("replace").value;
        var message = messageElement.value;

        if (message && findValue && replaceValue) {
          var result = "";
          var count = 0;
          var index = 0;

          for (let i = 0; i < message.length; ) {
            console.log("length ", message.length);
            let foundIndex = message.indexOf(findValue, i);
            // it tells indexOf to start searching from that point onward, not from the beginning every time.
            console.log("foundIndex ", foundIndex);
            if (foundIndex === -1) {
              // No more matches, add the rest of the message
              result += message.slice(i);
              console.log("result1 ", result);
              break;
            }

            // Add text before the match and the replacement
            result += message.slice(i, foundIndex) + replaceValue;
            console.log("result2 ", result);
            i = foundIndex + findValue.length;
            console.log("i ", i);
            count++;
            console.log("count ", count);
          }

          messageElement.value = result;
          document.getElementById(
            "replacetext"
          ).innerText = `${count} replaced`;
        } else {
          document.getElementById("replacetext").innerText = `0 replaced`;
        }
      }
      function validateForm() {
        var value = document.getElementById("message").value;
        if (value == null || value.trim() == "") {
          document.getElementById("messageError").innerHTML =
            "Message must be filled out!";
          return false;
        } else {
          document.getElementById("messageError").innerHTML = "";
          return true;
        }
      }
    </script>
  </head>
  <body>
    <!-- Part1:  -->
    <h1><ins>Part 1:</ins></h1>
    <table border="1" width="50%">
      <tr>
        <th class="table-header" colspan="3">CSIT128: Assignment 1</th>
        <th class="table-header">Group T01</th>
      </tr>
      <tr>
        <td width="20%" rowspan="2">Student Number / Name / Email</td>
        <td>xxxxxxx</td>
        <td>Aung Thet Paing</td>
        <td>xxxxxxx@mymail.sim.edu.sg</td>
      </tr>
      <tr>
        <td>1051738</td>
        <td>Aung Myint Myat Phyo</td>
        <td>phyo006@mymail.sim.edu.sg</td>
      </tr>
    </table>
    <!-- Part2:  -->
    <h1>Part 2: Hello World program in different languages</h1>
    <ul>
      <li><a href="#session1">C++</a></li>
      <li><a href="#session2">C#</a></li>
      <li><a href="#session3">Python</a></li>
      <li><a href="#session4">HTML</a></li>
    </ul>
    <hr />
    <table class="part2-table" id="session1">
      <tr style="margin-bottom: 20px">
        <td><strong>C++</strong></td>
      </tr>
      <tr>
        <td><img src="./CPP.png" width="180" /></td>
        <td>
          <pre>
<code>
    #include &lt;iostream&gt;

    void main( ) {
        count << "Hello World!" << endl;
    }
</code>
</pre>
        </td>
      </tr>
    </table>
    <hr />
    <table class="part2-table" id="session2">
      <tr>
        <td><strong>C#</strong></td>
      </tr>
      <tr>
        <td><img src="./CS.png" width="180" /></td>
        <td>
          <pre>
<code>
    using System;

    class Program
    {
        static void Main()
        {
            Console.WriteLine("Hello, World!");
        }
    }
</code>
</pre>
        </td>
      </tr>
    </table>
    <hr />
    <table class="part2-table" id="session3">
      <tr>
        <td><strong>Python</strong></td>
      </tr>
      <tr>
        <td><img src="./Python-Language.jpg" width="180" /></td>
        <td>
          <pre>
<code>
    # Hello World program in Python

    print("Hello World!")
</code>
</pre>
        </td>
      </tr>
    </table>
    <hr />
    <table class="part2-table" id="session4">
      <tr>
        <td><strong>HTML</strong></td>
      </tr>
      <tr>
        <td><img src="./HTML.png" width="180" /></td>
        <td>
          <pre>
<code>
    &lt;html&gt;
    &lt;head&gt;
    &lt;title&gt;Hello&lt;/title&gt;
    &lt;/head&gt;
    &lt;body&gt;
    Hello World!
    &lt;/body&gt;
    &lt;/html&gt;
</code>
</pre>
        </td>
      </tr>
    </table>
    <!-- Part3:  -->
    <h1>Part 3: University policies and services</h1>
    <dl>
      <dt style="font-weight: bold; text-transform: uppercase">Plagiarism</dt>
      <dd>
        Plagiarism is treated seriously. If we suspect any work is copied, all
        students involved are likely to receive zero <br />
        for the entire assignment. Plagiarism has led to students being expelled
        from the University.<br />
        Please click
        <a
          href="https://www.uow.edu.au/student/support-services/academic-skills/online-resources/referencing-and-citing/plagiarism/"
          target="_blank"
          >here</a
        >
        to read more about Plagiarism.
      </dd>
      <br />
      <dt style="font-weight: bold; text-transform: uppercase">
        Academic Consideration
      </dt>
      <dd>
        We know that life isn't perfect and there may be a time when you can't
        hand in an assignment on time, or make it <br />
        to class or an exam. If you find yourself in a situation like this, you
        may be eligible for academic Consideration. <br />
        Academic Consideration is designed to help students when they are sick,
        injured, or where a serious, unplanned <br />
        situation has occurred that has affected their ability to study.
        <br />
        Please click
        <a
          href="https://www.uow.edu.au/student/admin/academic-consideration/"
          target="_blank"
          >here</a
        >
        to read more about Academic Consideration.
      </dd>
      <br />
      <dt style="font-weight: bold; text-transform: uppercase">
        Student Support Advisers
      </dt>
      <dd>
        If you have an issue or a problem that is affecting your study, then the
        Student Support Advisers may be able to <br />help. There are Student
        Support Advisers available to assist students who are studying at all
        UOW Campuses and <br />
        in all UOW Faculties. <br />
        Please click
        <a
          href="https://www.uow.edu.au/student/support-services/coordinators/"
          target="_blank"
          >here</a
        >
        to read more about Student Support Advisers.
        <br /><br />
        Student Support Adviser contact details for Faculty of Engineering and
        Information Sciences:
        <table border="1" width="25%">
          <tr>
            <td>
              <strong>Ann-Maree Smith</strong><br />Bld 40:133, Wollongong
              Campus <br />
              (02) 4221 4714 <br />Mon-Fri <br />ams@uow.edu.au
            </td>
            <td>
              <strong>Miltz Perez</strong><br />Bld 4:105, Wollongong Campus
              <br />
              (02) 4221 3833 <br />Mon-Fri <br />ams@uow.edu.au
            </td>
          </tr>
        </table>
      </dd>
      <br />
      <dt style="font-weight: bold; text-transform: uppercase">
        DISABILITY SERVICES
      </dt>
      <dd>
        Disability Services provide advice and support for students with a
        disability or health condition. Our aim is to <br />
        ensure students with a disability realise their full academic potential.
        We also provide support for those who are <br />
        the primary carers for those with a medical condition or disability.
        <br />
        Please click
        <a
          href="https://www.uow.edu.au/business-law/about/equity-diversity-inclusion/disability-resources/support-pathways-for-students/"
          target="_blank"
          >here</a
        >
        to read more about Disability Services.
      </dd>
    </dl>
    <!-- Part4:  -->
    <h1><ins>Part 4:</ins></h1>
    <form
      action="https://translate.google.com"
      method="get"
      onclick="return validateForm();"
    >
      <table>
        <tr>
          <td>Name :</td>
          <td><input type="text" id="name" onchange="checkName();" /></td>
          <td class="errorMessage" id="nameError"></td>
        </tr>
        <tr>
          <td>Module code :</td>
          <td><input type="text" id="module" onchange="checkModule();" /></td>
          <td class="errorMessage" id="moduleError"></td>
        </tr>
        <tr>
          <td>Current date :</td>
          <td>
            <input type="text" id="date" size="25" disabled />
          </td>
        </tr>
        <tr>
          <td colspan="3"><hr /></td>
        </tr>
        <tr>
          <td>Message :</td>
          <td colspan="2">
            <textarea
              id="message"
              name="text"
              rows="3"
              cols="20"
              onchange="checkMessage();"
            >
Hello 202507</textarea
            >
          </td>
          <td class="errorMessage" id="messageError"></td>
        </tr>
        <tr>
          <td>Find :</td>
          <td><input type="text" id="find" onchange="findMessage();" /></td>
          <td>
            <button type="button" id="replacebtn" onclick="handleReplace();">
              Find & Replace
            </button>
          </td>
        </tr>
        <tr>
          <td>Replace :</td>
          <td><input type="text" id="replace" disabled /></td>
          <td id="replacetext">0 replaced</td>
        </tr>
        <tr>
          <td colspan="3"><hr /></td>
        </tr>
        <tr>
          <td>Source language :</td>
          <td style="text-align: center">
            <input type="radio" name="sl" value="en" checked />English
          </td>
          <td><input type="radio" name="sl" value="ms" />Malay</td>
        </tr>
        <tr>
          <td>Target language :</td>
          <td colspan="2">
            <select name="tl" style="padding: 7px; border-radius: 5px">
              <option value="zh-CN" selected>Chinese</option>
              <option value="ja">Japan</option>
              <option value="ko">Korean</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><button type="submit">Translate</button></td>
          <td>
            <button type="reset" onclick="setTimeout(getCurrentDate, 0);">
              Reset
            </button>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
