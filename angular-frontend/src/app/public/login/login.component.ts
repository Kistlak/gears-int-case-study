import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  form: any = FormGroup;
  regErr: any = false;
  errText: any;
  regTwo: any = false;

  constructor(private fb: FormBuilder,
              private http: HttpClient,
              private router: Router) {}

  ngOnInit(): void {
    this.form = this.fb.group({
        email: '',
        password: ''
    });
  }

  submit() {
   const formData = this.form.getRawValue();

   const data = {
       email: formData.email,
       password: formData.password
   };

   this.http.post('http://127.0.0.1:8000/api/login', data).subscribe(
       (result: any) => {
         localStorage.setItem('token', result.token);
         this.regErr = false;
         this.router.navigate(['/secure']);
       },
       error => {
           if(error.error.error) {
               this.regErr = true;
               this.regTwo = false;
               this.errText = error.error.error;
           } else {
               this.regTwo = true;
               this.regErr = false;
           }
       }
   );

  }

}
