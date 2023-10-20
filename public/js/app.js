


class Application {

    apiServer = "http://127.0.0.1:7000/api/";

    allRequest = this.findElement('all_request');
    successfullyRequest = this.findElement('successfully_request');
    failedRequest = this.findElement('failed_request');



    constructor() {
        for (let i = 1; i <= 100; i++)
        {
            this.pingRequest();
        }
    }

    findElement(selector)
    {
        return $("#" + selector);
    }

    setAllRequest(count)
    {
        this.allRequest.html(count)
    }

    getAllRequest()
    {
        return parseInt(this.allRequest.html());
    }

    setSuccessRequest(count)
    {
        this.successfullyRequest.html(count)
    }

    getSuccessRequest()
    {
        return parseInt(this.successfullyRequest.html());
    }

    setFailedRequest(count)
    {
        this.failedRequest.html(count)
    }

    getFailedRequest()
    {
        return parseInt(this.failedRequest.html());
    }
    increaseAllRequest()
    {
        let allRequest = this.getAllRequest();
        allRequest+= 1;
        this.setAllRequest(allRequest);
    }
    increaseSuccessRequest()
    {
        let count = this.getSuccessRequest();
        count+= 1;
        this.setSuccessRequest(count);
    }
    increaseFailedRequest()
    {
        let count = this.getFailedRequest();
        count+= 1;
        this.setFailedRequest(count);
    }

    pingRequest()
    {
        this.increaseAllRequest();
        const url = this.apiServer + 'ping';
        const appInstance = this;
        const requester = axios.create();
        requester.get(url)
            .then(function (response){
                if (response.data.status)
                {
                    appInstance.increaseSuccessRequest();
                }
            })
            .catch(function (error) {
                appInstance.increaseFailedRequest();
                console.log('Error in sending request to server');
            });
    }

    pingRequestWithAjax() {
        this.increaseAllRequest();
        const url = this.apiServer + 'ping';
        const appInstance = this;
        const xhr = new XMLHttpRequest();

        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                const response = JSON.parse(xhr.responseText);
                if (response.status) {
                    appInstance.increaseSuccessRequest();
                }
            } else {
                appInstance.increaseFailedRequest();
                console.log('Error in sending request to server');
            }
        };

        xhr.onerror = function() {
            appInstance.increaseFailedRequest();
            console.log('Error in sending request to server');
        };

        xhr.send();
    }



}


document.addEventListener('DOMContentLoaded', function() {

    const app = new Application();
});