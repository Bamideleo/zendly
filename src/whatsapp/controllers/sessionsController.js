import { isSessionExists, createSession, getSession, deleteSession } from './../whatsapp.js'
import express from 'express'
import axios from 'axios'
import queryString from 'query-string'
import response from './../response.js'
import { rmSync, readdir } from 'fs'
const app = express()

const find = (req, res) => {
      readdir('./sessions/md_'+res.locals.sessionId, (err, files) => {
          if (err){
            response(res, 404, false, 'Session not found. ERR:: 01')
          } else {
            if(files.length>0){
                response(res, 200, true, 'Session found.')
            }else{
                response(res, 404, true, 'Session not found.')
            }
          }
      })
}

const status = (req, res) => {
    const states = ['connecting', 'connected', 'disconnecting', 'disconnected']

    const session = getSession(res.locals.sessionId)
    let state = states[session.ws.readyState]

    state =
        state === 'connected' && typeof (session.isLegacy ? session.state.legacy.user : session.user) !== 'undefined'
            ? 'authenticated'
            : state

    response(res, 200, true, '', { status: state })
}

const add = (req, res) => {
    const { id, isLegacy, domain } = req.body

    if (isSessionExists(id)) {
        return response(res, 409, false, 'Session already exists, please use another id.')
    }

    try{
        createSession(id, isLegacy === 'true', res)
//        licenseCheck(domain,id, isLegacy === 'true', res)
    }catch {
        response(res, 500, false, 'Unable to create QR code.')
    }
}

const del = async (req, res) => {
    const { id } = req.params
    const session = getSession(id)

    try {
        await session.logout()
    } catch {

    } finally {
        deleteSession(id, session.isLegacy)
    }

    response(res, 200, true, 'The session has been successfully deleted.')
}

const licenseCheck = async(req, id, isLegacy = false, res = null) => {
     axios.post('https://license.igensolutionsltd.com/app',
    queryString.stringify({
            domain_check: req
    }), {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      }
    }).then(function(response) {
        if(response.status==200){
            try{
                createSession(id, isLegacy === 'true', res)
            }catch{
                response(res, 500, false, 'Unable to create QR code. ERROR -E1')
            }
        }else{
            response(res, 500, false, 'Unable to create QR code. Make sure you are using valid license')
        }
    });
}

export { find, status, add, del }
