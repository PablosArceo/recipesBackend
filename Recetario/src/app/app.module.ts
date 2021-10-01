import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { RecetarioComponent } from './components/recetario/recetario.component';

import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { LoginServiceService } from './login-service.service';

@NgModule({
  declarations: [
    AppComponent,
    RecetarioComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule
  ],
  providers: [
    LoginServiceService
  ],
    
  bootstrap: [AppComponent]
})
export class AppModule { }
