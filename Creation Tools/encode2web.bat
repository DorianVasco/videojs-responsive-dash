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
echo pfad = %inputPath%
echo datei = %inputFileName%

set tempPath=%inputPath%tmp-output
set outputPath=%inputPath%Output
:: create temp directory for  encoding
mkdir "%tempPath%"

:: create output directory
mkdir "%outputPath%"

set /p vScale="Set video width: "
set /p vBitrate="Set bitrate (e.g. 2000): "

:: set average bitrate
set /A vAvg=vBitrate-(vBitrate/6)

echo creating WEBM..
::ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vAvg%k -maxrate %vBitrate%k -bufsize %vBitrate%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm"
::ffmpeg -i movie.file -vcodec libvpx -b:v 600k -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -vf scale=480:-1 -map 0 out.webm

echo creating OGV..
::ffmpeg -y -i "%inputFile%" -vcodec libtheora -b:v %vAvg%k -maxrate %vBitrate%k -bufsize %vBitrate%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.ogv"
::ffmpeg -i movie.file -vcodec libtheora -b:v 600k -acodec libvorbis -b:a 96k -vf scale=480:-1 -map 0 out.ogv

echo creating MP4..
::ffmpeg -y -i "%inputFile%" -c:v libx264 -b:v %vAvg%k -maxrate %vBitrate%k -bufsize %vBitrate%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"


ffmpeg -y -i "%inputFile%" -vcodec libvpx -b:v %vAvg%k -maxrate %vBitrate%k -bufsize %vBitrate%k -vf "scale=-2:%vScale%" -acodec libvorbis -ac 2 -b:a 96k -ar 44100 -map 0 "%outputPath%\%inputFileName%.webm" -vcodec libx264 -b:v %vAvg%k -maxrate %vBitrate%k -bufsize %vBitrate%k -vf "scale=-2:%vScale%" "%outputPath%\%inputFileName%.mp4"


:finish

:: remove temp directory with its contents
rmdir "%tempPath%" /s /q

echo FINISHED!

pause