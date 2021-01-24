import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Router} from '@angular/router';

@Component({
  selector: 'app-add-books',
  templateUrl: './add-books.component.html',
  styleUrls: ['./add-books.component.scss']
})
export class AddBooksComponent implements OnInit {

    form: any = FormGroup;
    userId: any;
    headersNew: any;
    message: any;

    constructor(private fb: FormBuilder,
                private http: HttpClient,
                private router: Router) { }

    ngOnInit(): void {
        this.form = this.fb.group({
            book_name: ['', Validators.required],
            description: ['', Validators.required],
            price: ['', Validators.required]
        });

        this.headersNew = new HttpHeaders({
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': `application/json`,
            'Content-Type': `application/json`
        });

        // get current user info
        this.http.get('http://127.0.0.1:8000/api/user', {headers: this.headersNew}).subscribe(
            (result: any) => {
                this.userId = result.user.id;
            },
            error => {
                localStorage.removeItem('token');
                this.router.navigate(['/login']);
            }
        );
    }

    submit() {
        const formData = this.form.getRawValue();

        const data = {
            user_id: this.userId,
            book_name: formData.book_name,
            description: formData.description,
            price: formData.price
        };

        this.http.post('http://127.0.0.1:8000/api/add_books', data, {headers: this.headersNew}).subscribe(
            (result: any) => {
                if(result.message === "You are not authorized to do this") {
                  this.message = "You are not authorized to do this";
                } else {
                    this.message = result.message;
                }
            },
            error => {
                console.log(error);
            }
        );
    }

}
