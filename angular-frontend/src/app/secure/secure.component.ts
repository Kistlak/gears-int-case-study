import { Component, OnInit } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Router} from '@angular/router';

@Component({
  selector: 'app-secure',
  templateUrl: './secure.component.html',
  styleUrls: ['./secure.component.scss']
})
export class SecureComponent implements OnInit {

  user: any;
  loggedIn: any = true;
  allDetails: any;
  allStatus: any;

  constructor(private http: HttpClient,
              private router: Router) { }

  ngOnInit(): void {
      const headers = new HttpHeaders({
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': `application/x-www-form-urlencoded`
      });

      // get current user info
      this.http.get('http://127.0.0.1:8000/api/user', {headers: headers}).subscribe(
          (result: any) => {
              this.loggedIn = true;
              this.user = result;
          },
          error => {
              localStorage.removeItem('token');
              this.router.navigate(['/login']);
              this.loggedIn = false;
          }
      );

      // get all users info
      this.http.get('http://127.0.0.1:8000/api/all_users', {headers: headers}).subscribe(
          (result: any) => {
              this.allStatus = true;
              this.allDetails = result.all_users;
          },
          error => {
              this.allStatus = false;
          }
      );
  }

}
