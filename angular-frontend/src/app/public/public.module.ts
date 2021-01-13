import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {PublicComponent} from './public.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import {RouterModule} from '@angular/router';
import {ReactiveFormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';
import { RegisterComponent } from './register/register.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatAutocompleteModule} from '@angular/material/autocomplete';
import {DataTablesModule} from 'angular-datatables';
import { AddBooksComponent } from './add-books/add-books.component';



@NgModule({
  declarations: [
      PublicComponent,
      HomeComponent,
      LoginComponent,
      RegisterComponent,
      AddBooksComponent
  ],
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatAutocompleteModule,
    DataTablesModule
  ]
})
export class PublicModule { }
