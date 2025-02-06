<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="<?= base_url('css/calculadora.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="box">
    <div class="calculator">
            <div class="calculator-box">
                <div class="calculator-type">
                    <button name="estander" class="estander selected">Estander</button>
                    <!--<button name="cientifica" class="cientifica">Cientifica</button>-->
                </div>
                <div class="result">
                    <span id="wholeOp" class="expression"></span>
                    <span id="result" class="result">0</span>
                </div>
                <div class="calculator-elements">
                    <table>
                        <tr>
                            <td><button class="grey" onclick="addOperation('%')">%</button></td>
                            <td><button class="grey" onclick="clearEntry()">CE</button></td>
                            <td><button class="grey" onclick="clearAll()">C</button></td>
                            <td><button class="operation" onclick="deleteLast()">DEL</button></td>
                        </tr>
                        <tr>
                            <td><button class="operation" onclick="addOperation('^','^')">x^y</button></td>
                            <td><button class="operation" onclick="addOperation('!','!')">x!</button></td>
                            <td><button class="operation" onclick="addOperation('rand','rand')">RAN</button></td>
                            <td><button class="operation" onclick="addOperation('/','&divide;')">&divide;</button></td>
                        </tr>
                        <tr>
                            <td><button onclick="addNumber(7)">7</button></td>
                            <td><button onclick="addNumber(8)">8</button></td>
                            <td><button onclick="addNumber(9)">9</button></td>
                            <td><button class="operation" onclick="addOperation('*','&times;')">&times;</button></td>
                        </tr>
                        <tr>
                            <td><button onclick="addNumber(4)">4</button></td>
                            <td><button onclick="addNumber(5)">5</button></td>
                            <td><button onclick="addNumber(6)">6</button></td>
                            <td><button class="operation" onclick="addOperation('-','&minus;')">&minus;</button></td>
                        </tr>
                        <tr>
                            <td><button onclick="addNumber(1)">1</button></td>
                            <td><button onclick="addNumber(2)">2</button></td>
                            <td><button onclick="addNumber(3)">3</button></td>
                            <td><button class="operation" onclick="addOperation('+','&plus;')">&plus;</button></td>
                        </tr>
                        <tr>
                            <td><button onclick="invertSign()">+/-</button></td>
                            <td><button onclick="addNumber(0)">0</button></td>
                            <td><button onclick="addDot()">,</button></td>
                            <td><button class="operation" onclick="submitform()">=</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--
            <div class="historial">
                <span>Historial</span>
            </div>
            -->
        </div>
    </div>
    <script>
        let expression = '';
        let expressionDisplay = '';
        let resultOp = '';
        var resultDisplay = document.getElementById('result');
        var wholeOperationDisplay = document.getElementById('wholeOp');

        function addNumber(num) {
            expression += num;
            expressionDisplay += num;
            if (expressionDisplay !== '') {
                let partsexp = expression.split(' ');
                let lastPart = partsexp.pop();
                updateResult(lastPart);
            }
        }


        async function addOperation(op, opSign) {
            let partsexp = expression.split(' ');
            console.log('Current expression:', expression);

            if (expression !== '') {
              
                if (partsexp.length === 3) {
                    await submitform();
                }

               
                expression += ` ${op} `;
                expressionDisplay += ` ${opSign} `;
                updateDisplay();
            }
        }


        function addRand() {
            let partsexp = expression.split(' ');
            let lastNumber = partsexp.pop();


        }


        function clearEntry() {
            expressionDisplay = '';
            updateDisplay();
        }


        function clearAll() {
            expression = '';
            expressionDisplay = '';
            resultDisplay.innerText = '0';
            wholeOperationDisplay.innerText = '';
        }


        function deleteLast() {
            expressionDisplay = expressionDisplay.trim();
            if (expressionDisplay.charAt(expressionDisplay.length - 1) === ' ') {
                expressionDisplay = expressionDisplay.slice(0, -3);
            } else {
                expressionDisplay = expressionDisplay.slice(0, -1);
            }
            updateDisplay();
        }


        function updateDisplay() {
            wholeOperationDisplay.innerText = expressionDisplay;
        }

        function updateResult(num) {
            resultDisplay.innerHTML = num;
        }

        function submitform() {
            if (expression !== '') {
                fetch('/calculadora/procesar', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            expression: expression
                        })
                    })
                    .then(response => response.text())
                    .then(result => {
                        resultDisplay.innerText = result;
                        expression = result;
                        updateDisplay();
                        expressionDisplay = result;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        function addDot() {
            expression += '.';
            expressionDisplay += ',';
            updateDisplay();
        }

        function invertSign() {
            let parts = expressionDisplay.split(' ');
            let partsexp = expression.split(' ');
            let lastPart = parts.pop();
            partsexp.pop();

            if (lastPart !== '') {
                lastPart = parseFloat(lastPart) * -1;
                parts.push(lastPart);
                partsexp.push(lastPart);
            } else {
                parts.push(lastPart);
                partsexp.push(lastPart)
            }
            expressionDisplay = parts.join(' ');
            expression = partsexp.join(' ');
            updateResult(lastPart);
        }
    </script>
</body>

</html>