@echo off
echo ===============================
echo == MEGA MP4:WEBM:OGV CREATOR ==
echo ===============================

:: get input file per drag and drop
set /p inputFile="Drag input file here: "

set inputFile=%inputFile:"=%

:: extract path from input
FOR %%i IN ("%inputFile%") DO (
  set inputPath=%%~dpi
  set inputFileName=%%~ni
)
::echo pfad = %inputPath%
::echo datei = %inputFileName%

set tempPath=%inputPath%tmp-output
set outputPath=%inputPath%Output

:: create output directory
mkdir "%outputPath%"

set /p vScale="Set video height (e.g. 1080 or 720 or whatever):"
set /p vBitrate="Set bitrate (e.g. 2000): "

:: set average bitrate
set /A vMax=vBitrate+(vBitrate/6)

echo creating WEBM..
::ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm"
::ffmpeg -i movie.file -vcodec libvpx -b:v 600k -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -vf scale=480:-1 -map 0 out.webm

echo creating MP4..
::ffmpeg -y -i "%inputFile%" -c:v libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"


ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm" -vcodec libx264 -b:v %vBitrate%k -maxrate %vMax%k -bufsize %vMax%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"


:finish


echo FINISHED!

