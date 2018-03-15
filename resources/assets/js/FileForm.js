import Errors from './Errors';
class FileForm {
    constructor(data) {
        this.originalData = data;
        this.finalData = new FormData();
        for (let field in data) {
            this[field] = data[field];
        }
        this.file_fields = [];
        this.errors = new Errors();
    }
    addFile (key, file, filename) {
        this.file_fields.push(key);
        this.finalData.append(key,file,filename);
        return this;
    }
    clearFiles(){
        this.file_fields = [];
        return this;
    }
    data() {
        for (let property in this.originalData) {
            this.finalData.append(property,this[property]);
        }
        return this.finalData;
    }
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }
        for(let inp in this.file_fields){
            let oldInput = document.querySelector('input[name="'+this.file_fields[inp]+'"]');
            oldInput.type = oldInput.value = '';oldInput.type = 'file';
        }
        this.file_fields = [];
        this.errors.clear();
        this.finalData = new FormData();
    }
    post(url,option) {
        return this.submit('post', url,option);
    }
    put(url) {
        return this.submit('put', url);
    }
    patch(url) {
        return this.submit('patch', url);
    }
    delete(url) {
        return this.submit('delete', url);
    }
    submit(requestType,url,option) {
        var config = {
            onUploadProgress: function(progressEvent) {
                var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                if(option.upload_div){
                    let pDiv = document.querySelector('#'+option.upload_div);
                    pDiv.value = percentCompleted;
                }
            }
        };
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data(),config)
                .then(response => {
                    this.onSuccess(response.data);
                    resolve(response.data);
                })
                .catch(error => {
                    if(error.response && (error.response !=='') && (error.response !== undefined)){
                        this.onFail(error.response.data);
                        reject(error.response.data);
                    }
                });
        });
    }
    onSuccess(data) {
        this.reset();
    }
    onFail(errors) {
        this.errors.record(errors);

    }
}
export default FileForm;