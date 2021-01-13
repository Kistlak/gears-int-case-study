import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  form: any = FormGroup;
  regErr: any = false;
  errText: any;

  constructor(private fb: FormBuilder,
              private http: HttpClient,
              private router: Router) { }

  ngOnInit(): void {
    this.form = this.fb.group({
        first_name: ['', Validators.required],
        last_name: ['', Validators.required],
        email: ['', [Validators.required, Validators.email]],
        password: ['', Validators.required],
        password_confirmation: ['', Validators.required],
    });
  }

  submit() {
      const formData = this.form.getRawValue();

      this.http.post('http://127.0.0.1:8000/api/register_user', formData).subscribe(
          (result: any) => {
              this.regErr = false;
              this.router.navigate(['/login']);
          },
          error => {
              this.regErr = true;
              this.errText = error.error.error;
              console.log(error.error.error);
          }
      );
  }

}
