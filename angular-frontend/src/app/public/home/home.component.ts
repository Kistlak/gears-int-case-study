import { Component, OnInit } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import {FormBuilder, FormGroup} from '@angular/forms';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

    form: any = FormGroup;
    searchResults: any;
    searchStatus: any = true;

    constructor(private fb: FormBuilder,
                private http: HttpClient,
                private router: Router) {}

    ngOnInit(): void {
        this.form = this.fb.group({
            search_book: ''
        });
    }

    submit() {
        const formData = this.form.getRawValue();

        const data = {
            search_book: formData.search_book
        };

        this.http.post('http://127.0.0.1:8000/api/search_results', data).subscribe(
            (result: any) => {
              if(result.response_count === 0) {
                  this.searchStatus = false;
              } else {
                  this.searchResults = result.books_from_authors;
                  this.searchStatus = true;
              }
            },
            error => {
                this.searchStatus = false;
                console.log(error);
            }
        );

    }

}
