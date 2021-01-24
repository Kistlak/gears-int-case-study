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
  setStatus: any;
  headersNew: any;

  constructor(private http: HttpClient,
              private router: Router) { }

  ngOnInit(): void {
      this.headersNew = new HttpHeaders({
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Accept': `application/json`,
          'Content-Type': `application/json`
      });

      // get current user info
      this.http.get('http://127.0.0.1:8000/api/user', {headers: this.headersNew}).subscribe(
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
      this.http.get('http://127.0.0.1:8000/api/all_users', {headers: this.headersNew}).subscribe(
          (result: any) => {
              if(result.message === "You are not authorized to do this") {
                  this.allStatus = false;
              } else {
                  this.allStatus = true;
                  this.allDetails = result.all_users;
              }
          },
          error => {
              this.allStatus = false;
          }
      );
  }

    change_status(ManageUpdate: any)
    {
        if(ManageUpdate.status === "1") {
            this.setStatus = 0;
        } else {
            this.setStatus = 1;
        }

        const data = {
            user_id: ManageUpdate.user_id,
            status: this.setStatus
        };

        this.http.post('http://127.0.0.1:8000/api/change_status', data, {headers: this.headersNew}).subscribe(
            (result: any) => {
                window.location.reload(false);
            },
            error => {
                console.log(error);
            }
        );
    }

}
